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
        if (!\blaze\lang\String::asWrapper($package)->endsWith('\\'))
            $package .= '\\';
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
        $class = new metainfo\ClassMetaInfo();
        $class->setName($this->package . $this->getClassName($tmd->getTableName()));
        $class->setTable($tmd->getTableName());

        $this->reversePrimaryColumns($class, $tmd->getPrimaryKeys());
        $this->reverseNormalColumns($class, $tmd->getColumns());
        $this->reverseForeignColumns($class, $tmd->getForeignKeys());
        $this->reverseInverseColumns($class, $tmd->getReferencingKeys());

        $root = $doc->createElement('persistence-mapping');
        $doc->appendChild($root);
        $class->toXml($root, $doc);
        $doc->save($file->getAbsolutePath());
    }

    public function reverseView(\blaze\ds\meta\ViewMetaData $dbmd) {

    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $primaryKeys
     */
    private function reversePrimaryColumns(metainfo\ClassMetaInfo $elem, $primaryKeys) {
        foreach ($primaryKeys as $primaryKey) {
            $id = new metainfo\IdMetaInfo();
            $id->setName($this->getMemberName($primaryKey->getColumnName()));
            $id->setType($primaryKey->getColumnClassName());
            $col = new metainfo\ColumnMetaInfo();
            $col->setName($primaryKey->getColumnName());
            $id->setColumn($col);
            $elem->addMember($id);
        }
    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $primaryKeys
     */
    private function reverseNormalColumns(metainfo\ClassMetaInfo $elem, $columns) {
        foreach ($columns as $column) {
            if (!$column->isPrimaryKey() && !$column->isForeignKey()) {
                $property = new metainfo\PropertyMetaInfo();
                $property->setName($this->getMemberName($column->getColumnName()));
                $property->setType($column->getColumnClassName());
                $col = new metainfo\ColumnMetaInfo();
                $col->setName($column->getColumnName());
                $col->setLength($column->getColumnLength());
                $property->setColumn($col);
                $elem->addMember($property);
            }
        }
    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $primaryKeys
     */
    private function reverseForeignColumns(metainfo\ClassMetaInfo $elem, $columns) {
        foreach ($columns as $column) {
            $foreignConstraint = null;

            foreach ($column->getConstraints() as $constraint) {
                if ($constraint instanceof \blaze\ds\meta\ForeignKeyMetaData) {
                    $foreignConstraint = $constraint;
                    break;
                }
            }

            $property = new metainfo\ManyToOneMetaInfo();
            $property->setName($this->getMemberName($foreignConstraint->getReferencedColumn()->getTable()->getTableName()));
            $property->setClassName($this->package . $this->getClassName($foreignConstraint->getReferencedColumn()->getTable()->getTableName()));
            $col = new metainfo\ColumnMetaInfo();
            $col->setName($column->getColumnName());
            $col->setNotNull($column->isNullable() ? 'false' : 'true');
            $property->setColumn($col);
            $elem->addMember($property);
        }
    }

    /**
     *
     * @param \DOMDocument $doc
     * @param \DOMElement $elem
     * @param blaze\collections\ListI[blaze\ds\meta\ColumnMetaData] $primaryKeys
     */
    private function reverseInverseColumns(metainfo\ClassMetaInfo $elem, $columns) {
        foreach ($columns as $column) {
            $inverseColumns = $column->getTable()->getColumns();
            if (count($inverseColumns) == 2 &&
                    $inverseColumns[0]->isPrimaryKey() &&
                    $inverseColumns[1]->isPrimaryKey() &&
                    $inverseColumns[0]->isForeignKey() &&
                    $inverseColumns[1]->isForeignKey()) {

                $secondColumn = $inverseColumns[1]->getColumnName()->equals($column->getColumnName()) ? $inverseColumns[0] : $inverseColumns[1];
                $otherTable = null;

                foreach ($secondColumn->getConstraints() as $constraint) {
                    if ($constraint instanceof \blaze\ds\meta\ForeignKeyMetaData) {
                        $otherTable = $constraint->getReferencedColumn()->getTable();
                        break;
                    }
                }

                $this->makeManyToMany($elem, $column, $secondColumn, $otherTable);
            } else {
                $this->makeOneToMany($elem, $column);
            }
        }
    }

    private function makeManyToMany(metainfo\ClassMetaInfo $elem, $column, $secondColumn, $otherTable) {
        $property = new metainfo\SetMetaInfo();
        $property->setName($this->getMemberName($otherTable->getTableName() . 's'));
        $property->setSchema($column->getTable()->getSchema()->getSchemaName());
        $property->setTable($column->getTable()->getTableName());
        $property->setCascade('all');
        $key = new metainfo\KeyMetaInfo();
        $col = new metainfo\ColumnMetaInfo();
        $col->setName($column->getColumnName());
        $key->setColumn($col);
        $property->setKey($key);

        $assoc = new metainfo\ManyToManyMetaInfo();
        $assoc->setColumn($secondColumn->getColumnName());
        $assoc->setClassName($this->package . $this->getClassName($otherTable->getTableName()));
        $property->setAssociation($assoc);
        $elem->addMember($property);
    }

    private function makeOneToMany(metainfo\ClassMetaInfo $elem, $column) {
        $property = new metainfo\SetMetaInfo();
        $property->setName($this->getMemberName($column->getTable()->getTableName() . 's'));
        $property->setInverse('true');
        $key = new metainfo\KeyMetaInfo();
        $col = new metainfo\ColumnMetaInfo();
        $col->setName($column->getColumnName());
        $col->setNotNull($column->isNullable() ? 'false' : 'true');
        $key->setColumn($col);
        $property->setKey($key);

        $assoc = new metainfo\OneToManyMetaInfo();
        $assoc->setClassName($this->package . $this->getClassName($column->getTable()->getTableName()));
        $property->setAssociation($assoc);
        $elem->addMember($property);
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
