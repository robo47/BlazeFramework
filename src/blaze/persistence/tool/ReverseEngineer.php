<?php

namespace blaze\persistence\tool;

use blaze\lang\Object;

/**
 * Description of ReverseEngineer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 */
class ReverseEngineer extends Object {

    private $dir;
    private $package;

    public function __construct(\blaze\io\File $dir, $package) {
        $this->dir = $dir;
        $this->package = $package;
    }

    public function reverseDatabase(\blaze\ds\meta\DatabaseMetaData $dbmd) {
        foreach ($dbmd->getSchemas() as $schema) {
            $this->reverseSchema($schema);
        }
    }

    public function reverseSchema(\blaze\ds\meta\SchemaMetaData $smd) {
        foreach ($smd->getTables() as $table) {
            $this->reverseTable($table);
        }
        foreach ($smd->getViews() as $view) {
            $this->reverseView($view);
        }
    }

    public function reverseTable(\blaze\ds\meta\TableMetaData $tmd) {
        $file = new \blaze\io\File($this->dir, $this->getClassName($tmd->getTableName()) . '.xml');
        $doc = new \DOMDocument('1.0', 'utf-8');
        $class = \blaze\persistence\meta\ClassDescriptor::getClassDescriptor($this->getClassName($tmd->getTableName()));
        $class->setPackage($this->package);
        $class->setTableDescriptor(\blaze\persistence\meta\TableDescriptor::getTableDescriptor($tmd->getTableName()));

        $this->reversePrimaryColumns($class, $tmd->getPrimaryKeys());
        $this->reverseNormalColumns($class, $tmd->getColumns());
        $this->reverseForeignColumns($class, $tmd->getForeignKeys());
        $this->reverseInverseColumns($class, $tmd->getReferencingKeys());

        $t = new \blaze\persistence\meta\driver\XmlMetaDriver();
        $t->save($class, $file);
    }

    public function reverseView(\blaze\ds\meta\ViewMetaData $dbmd) {

    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $primaryKeys
     */
    private function reversePrimaryColumns(\blaze\persistence\meta\ClassDescriptor $elem, $primaryKeys) {
        foreach ($primaryKeys as $primaryKey) {
            $id = new \blaze\persistence\meta\IdDescriptor();
            $field = new \blaze\persistence\meta\SingleFieldDescriptor();
            $id->setSingleFieldDescriptor($field);
            
            $field->setName($this->getMemberName($primaryKey->getName()));
            $field->setType($primaryKey->getClassType());

            $col = new \blaze\persistence\meta\ColumnDescriptor();
            $col->apply($primaryKey);
            $field->setColumnDescriptor($col);
            $elem->addIdentifier($id);
        }
    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $primaryKeys
     */
    private function reverseNormalColumns(\blaze\persistence\meta\ClassDescriptor $elem, $columns) {
        foreach ($columns as $column) {
            if (!$column->isPrimaryKey() && !$column->isForeignKey()) {
                $field = new \blaze\persistence\meta\SingleFieldDescriptor();

                $field->setName($this->getMemberName($column->getName()));
                $field->setType($column->getClassType());

                $col = new \blaze\persistence\meta\ColumnDescriptor();
                $col->apply($column);
                $field->setColumnDescriptor($col);
                $elem->addSingleField($field);
            }
        }
    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $columns
     */
    private function reverseForeignColumns(\blaze\persistence\meta\ClassDescriptor $elem, $columns) {
        $usedNames = array();

        foreach ($columns as $column) {
            $foreignConstraint = null;

            foreach ($column->getConstraints() as $constraint) {
                if ($constraint instanceof \blaze\ds\meta\ForeignKeyMetaData) {
                    $foreignConstraint = $constraint;
                    break;
                }
            }

            $field = new \blaze\persistence\meta\SingleFieldDescriptor();
            $name = $this->getMemberName($foreignConstraint->getReferencedColumn()->getTable()->getTableName());

            if(array_key_exists($name, $usedNames))
                    $name .= $usedNames[$name]++;
            else
                $usedNames[$name] = 0;

            $field->setName($name);
            $field->setType($this->package . '\\'. $this->getClassName($foreignConstraint->getReferencedColumn()->getTable()->getTableName()));

            $col = new \blaze\persistence\meta\ColumnDescriptor();
            $col->apply($column);
            $field->setColumnDescriptor($col);
            $elem->addSingleField($field);
        }
    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $columns
     */
    private function reverseInverseColumns(\blaze\persistence\meta\ClassDescriptor $elem, $columns) {
        $usedNames = array();

        foreach ($columns as $column) {
            $inverseColumns = $column->getTable()->getColumns();
            if (count($inverseColumns) == 2 &&
                    $inverseColumns[0]->isPrimaryKey() &&
                    $inverseColumns[1]->isPrimaryKey() &&
                    $inverseColumns[0]->isForeignKey() &&
                    $inverseColumns[1]->isForeignKey()) {

                $secondColumn = $inverseColumns[1]->getName()->equals($column->getName()) ? $inverseColumns[0] : $inverseColumns[1];
                $otherTable = null;

                foreach ($secondColumn->getConstraints() as $constraint) {
                    if ($constraint instanceof \blaze\ds\meta\ForeignKeyMetaData) {
                        $otherTable = $constraint->getReferencedColumn()->getTable();
                        break;
                    }
                }

                $name = $this->getMemberName($otherTable->getTableName());

                if(array_key_exists($name, $usedNames))
                        $usedNames[$name]++;
                else
                    $usedNames[$name] = 0;
                $this->makeManyToMany($elem, $column, $secondColumn, $otherTable, $usedNames[$name]);
            } else {
                $name = $this->getMemberName($column->getTable()->getTableName());

                if(array_key_exists($name, $usedNames))
                        $usedNames[$name]++;
                else
                    $usedNames[$name] = 0;

                $this->makeOneToMany($elem, $column, $usedNames[$name]);
            }
        }
    }

    private function makeManyToMany(\blaze\persistence\meta\ClassDescriptor $elem, $column, $secondColumn, $otherTable, $ident) {
        $property = new \blaze\persistence\meta\CollectionFieldDescriptor();
        $field = new \blaze\persistence\meta\SingleFieldDescriptor();
        $property->setFieldDescriptor($field);
        $ident = $ident > 0 ? ''.$ident : '';
        $field->setName($this->getMemberName($otherTable->getTableName() . 's' . $ident));
        //$property->setSchema($column->getTable()->getSchema()->getSchemaName());
        $property->setTableDescriptor(\blaze\persistence\meta\TableDescriptor::getTableDescriptor($column->getTable()->getTableName()));
        //$property->setCascade('all');
        $col = new \blaze\persistence\meta\ColumnDescriptor();
        $col->apply($column);
        $property->setColumnDescriptor($col);

        $junction = new \blaze\persistence\meta\ColumnDescriptor();
        $junction->apply($secondColumn);
        $property->setJunctionColumnDescriptor($junction);
        $property->setClassDescriptor(\blaze\persistence\meta\ClassDescriptor::getClassDescriptor($this->getClassName($otherTable->getTableName())));
        $elem->addCollectionField($property);
    }

    private function makeOneToMany(\blaze\persistence\meta\ClassDescriptor $elem, $column, $ident) {
        $property = new \blaze\persistence\meta\CollectionFieldDescriptor();
        $field = new \blaze\persistence\meta\SingleFieldDescriptor();
        $property->setFieldDescriptor($field);
        $ident = $ident > 0 ? ''.$ident : '';
        $field->setName($this->getMemberName($column->getTable()->getTableName() . 's' . $ident));
        //$property->setInverse('true');
        $col = new \blaze\persistence\meta\ColumnDescriptor();
        $col->apply($column);
        $property->setColumnDescriptor($col);

        $property->setClassDescriptor(\blaze\persistence\meta\ClassDescriptor::getClassDescriptor($this->getClassName($column->getTable()->getTableName())));
        $elem->addCollectionField($property);
    }

    private function getClassName($tableName) {
        $parts = \blaze\lang\String::asWrapper($tableName)->split('_', null, true);
        $className = '';

        foreach ($parts as $part) {
            $className .= $part->toUpperCase(true)->toNative();
        }

        return $className;
    }

    private function getMemberName($columnName) {
        $parts = \blaze\lang\String::asWrapper($columnName)->split('_', null, true);
        $memberName = array_shift($parts)->toLowerCase(true)->toNative();

        foreach ($parts as $part) {
            $memberName .= $part->toUpperCase(true)->toNative();
        }

        return $memberName;
    }

}

?>
