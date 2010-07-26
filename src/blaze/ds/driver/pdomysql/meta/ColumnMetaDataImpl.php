<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractColumnMetaData;

/**
 * Description of ColumnMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ColumnMetaDataImpl extends AbstractColumnMetaData {

    public function __construct(\blaze\ds\meta\TableMetaData $table, $columnName) {
        $this->table = $table;
        $this->columnName = \blaze\lang\String::asWrapper($columnName);
        $this->getColumnInfo();
    }

    /**
     * Map the database specific type names to class names.
     *
     * @return blaze\lang\String
     */
    private function getClassName($nativeName) {
        $className = null;
        switch (\blaze\lang\String::asNative($nativeName->toLowerCase())) {
            case 'decimal': $className = '\\blaze\\math\\BigDecimal';
                break;
            case 'int': $className = 'integer';
                break;
            case 'date': $className = '\\blaze\\util\\Date';
                break;
            case 'blob': $className = '\\blaze\\ds\\type\\Blob';
                break;
            default: $className = '\\blaze\\lang\\String';
                break;
        }
        return new \blaze\lang\String($className);
    }

    /**
     * Map the database specific type names to class names.
     *
     * @return blaze\lang\String
     */
    private function getColumnInfo() {
        $stmt = $this->table->getSchema()
                        ->getDatabaseMetaData()
                        ->getConnection()
                        ->prepareStatement('SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?');
        $stmt->setString(0, $this->table->getSchema()->getSchemaName());
        $stmt->setString(1, $this->table->getTableName());
        $stmt->setString(2, $this->columnName);
        $stmt->execute();
        $rs = $stmt->getResultSet();
        $rs->next();

        $this->columnDefault = $rs->getString('COLUMN_DEFAULT');
        $this->nullable = $rs->getBoolean('IS_NULLABLE');
        $this->columnTypeName = $rs->getString('DATA_TYPE');
        $this->columnClassName = $this->getClassName($this->columnTypeName);
        $this->columnLength = $rs->getInt('NUMERIC_SCALE');

        if ($this->columnLength == null)
            $this->columnLength = $rs->getInt('CHARACTER_MAXIMUM_LENGTH');

        $this->columnPrecision = $rs->getInt('NUMERIC_PRECISION');
        $this->signed = !$rs->getString('COLUMN_TYPE')->contains('unsigned');
        $extra = $rs->getString('EXTRA');
        $this->autoIncrement = $extra != null ? $extra->contains('auto_increment') : false;
        $this->columnComment = $rs->getString('COLUMN_COMMENT');

        $keyVal = $rs->getString('COLUMN_KEY');
        $this->primaryKey = $keyVal != null ? $keyVal->compareToIgnoreCase('PRI') == 0 : false;

        if ($this->primaryKey)
            $this->uniqueKey = true;
        else
            $this->uniqueKey = $keyVal != null ? $keyVal->compareToIgnoreCase('UNI') == 0 : false;

        $this->foreignKey = false;
        $rs->close();
        $stmt->close();

        $stmt = $this->table->getSchema()
                        ->getDatabaseMetaData()
                        ->getConnection()
                        ->prepareStatement('SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?');
        $stmt->setString(0, $this->table->getSchema()->getSchemaName());
        $stmt->setString(1, $this->table->getTableName());
        $stmt->setString(2, $this->columnName);
        $stmt->execute();
        $rs = $stmt->getResultSet();

        if ($rs->next() && $rs->getString('REFERENCED_TABLE_SCHEMA') != null)
            $this->foreignKey = true;
        $rs->close();
        $stmt->close();
    }

    /**
     * @return blaze\lang\String
     */
    public function getColumnName() {
        return $this->columnName;
    }

    /**
     * Native database types like varchar etc.
     *
     * @return blaze\lang\String
     */
    public function getColumnTypeName() {
        return $this->columnTypeName;
    }

    /**
     * PHP datatypes of the columns
     *
     * @return blaze\lang\String
     */
    public function getColumnClassName() {
        return $this->columnClassName;
    }

    /**
     * @return integer
     */
    public function getColumnLength() {
        return $this->columnLength;
    }

    /**
     * @return integer
     */
    public function getColumnPrecision() {
        return $this->columnPrecision;
    }

    /**
     * @return blaze\lang\String
     */
    public function getColumnDefault() {
        return $this->columnDefault;
    }

    /**
     * @return blaze\lang\String
     */
    public function getColumnComment() {
        return $this->columnComment;
    }

    /**
     * @return boolean
     */
    public function isNullable() {
        return $this->nullable;
    }

    /**
     * @return boolean
     */
    public function isAutoIncrement() {
        return $this->autoIncrement;
    }

    /**
     * @return boolean
     */
    public function isSigned() {
        return $this->signed;
    }

    /**
     * @return boolean
     */
    public function isPrimaryKey() {
        return $this->primaryKey;
    }

    /**
     * @return boolean
     */
    public function isForeignKey() {
        return $this->foreignKey;
    }

    /**
     * @return boolean
     */
    public function isUniqueKey() {
        return $this->uniqueKey;
    }

    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ConstraintMetaData]
     */
    public function getConstraints() {
        $stmt = null;
        $rs = null;
        $tblConst = array();
        $constraints = array();

        try {
            $stmt = $this->table->getSchema()->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?');
            $stmt->setString(0, $this->table->getSchema()->getSchemaName());
            $stmt->setString(1, $this->table->getTableName());
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next())
                $tblConst[$rs->getString('CONSTRAINT_NAME')->__toString()] = $rs->getString('CONSTRAINT_TYPE');

            if ($stmt != null)
                $stmt->close();
            if ($rs != null)
                $rs->close();

            $stmt = $this->table->getSchema()->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?');
            $stmt->setString(0, $this->table->getSchema()->getSchemaName());
            $stmt->setString(1, $this->table->getTableName());
            $stmt->setString(2, $this->columnName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next()) {
                switch ($tblConst[$rs->getString('CONSTRAINT_NAME')->__toString()]) {
                    case 'PRIMARY KEY':
                        $constraints[] = new ConstraintMetaDataImpl($this, $rs->getString('CONSTRAINT_NAME'), 'PRIMARY KEY');
                        break;
                    case 'FOREIGN KEY':
                        $refSch = $this->table
                                        ->getSchema()
                                        ->getDatabaseMetaData()
                                        ->getSchema($rs->getString('REFERENCED_TABLE_SCHEMA'));

                        if ($refSch == null)
                            break;

                        $refCol = $refSch->getTable($rs->getString('REFERENCED_TABLE_NAME'))
                                        ->getColumn($rs->getString('REFERENCED_COLUMN_NAME'));
                        $constraints[] = new ForeignKeyMetaDataImpl($this, $refCol, $rs->getString('CONSTRAINT_NAME'));
                        break;
                    case 'UNIQUE':
                        $constraints[] = new ConstraintMetaDataImpl($this, $rs->getString('CONSTRAINT_NAME'), 'UNIQUE KEY');
                        break;
                    default:
                        $constraints[] = new ConstraintMetaDataImpl($this, $rs->getString('CONSTRAINT_NAME'), 'UNKNOWN');
                        break;
                }
            }
        } catch (\blaze\ds\SQLException $e) {
            throw $e;
        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $constraints;
    }

    /**
     * @return blaze\ds\meta\ConstraintMetaData
     */
    public function getConstraint($constraintName) {
        $stmt = null;
        $rs = null;
        $constType = null;
        $constraint = null;

        try {
            $stmt = $this->table->getSchema()->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TABLE_CONSTRAINTS JOIN information_schema.KEY_COLUMN_USAGE ON KEY_COLUMN_USAGE.TABLE_SCHEMA = TABLE_CONSTRAINTS.TABLE_SCHEMA AND KEY_COLUMN_USAGE.TABLE_NAME = TABLE_CONSTRAINTS.TABLE_NAME AND KEY_COLUMN_USAGE.CONSTRAINT_NAME = TABLE_CONSTRAINTS.CONSTRAINT_NAME WHERE KEY_COLUMN_USAGE.TABLE_SCHEMA = ? AND KEY_COLUMN_USAGE.TABLE_NAME = ? AND KEY_COLUMN_USAGE.CONSTRAINT_NAME = ?');
            $stmt->setString(0, $this->table->getSchema()->getSchemaName());
            $stmt->setString(1, $this->table->getTableName());
            $stmt->setString(2, $constraintName);
            $stmt->execute();

            $rs = $stmt->getResultSet();
            $rsmd = $stmt->getMetaData();

            while ($rs->next()) {
                $tblConst[$rs->getString('CONSTRAINT_NAME')->__toString()]['type'] = $rs->getString('CONSTRAINT_TYPE');
                $tblConst[$rs->getString('CONSTRAINT_NAME')->__toString()]['columns'][] = array('column' => $this->table->getColumn($rs->getString('COLUMN_NAME')),
                                                                                                'REFERENCED_TABLE_SCHEMA' => $rs->getString('REFERENCED_TABLE_SCHEMA'),
                                                                                                'REFERENCED_TABLE_NAME' => $rs->getString('REFERENCED_TABLE_NAME'),
                                                                                                'REFERENCED_COLUMN_NAME' => $rs->getString('REFERENCED_COLUMN_NAME'));
            }

            if (count($tblConst) != 0) {
                foreach ($tblConst as $constName => $constOpt) {
                    if (count($constOpt['columns']) != 0) {
                        switch ($constOpt['type']) {
                            case 'PRIMARY KEY':
                                $cols = array();
                                foreach ($constOpt['columns'] as $column)
                                    $cols[] = $column['column'];

                                $constraint = new ConstraintMetaDataImpl($cols, $constName, 'PRIMARY KEY');
                                break;
                            case 'FOREIGN KEY':
                                $cols = array();
                                $refCols = array();

                                foreach ($constOpt['columns'] as $column) {
                                    $refSch = $this->table
                                                    ->getSchema()
                                                    ->getDatabaseMetaData()
                                                    ->getSchema($column['REFERENCED_TABLE_SCHEMA']);

                                    if ($refSch == null)
                                        break;
                                    $cols[] = $column['column'];
                                    $refCols[] = $refSch->getTable($column['REFERENCED_TABLE_NAME'])
                                                    ->getColumn($column['REFERENCED_COLUMN_NAME']);
                                }

                                $constraint = new ForeignKeyMetaDataImpl($cols, $refCols, $constName);
                                break;
                            case 'UNIQUE':
                                $cols = array();
                                foreach ($constOpt['columns'] as $column)
                                    $cols[] = $column['column'];

                                $constraint = new ConstraintMetaDataImpl($cols, $constName, 'UNIQUE KEY');
                                break;
                            default:
                                $cols = array();
                                foreach ($constOpt['columns'] as $column)
                                    $cols[] = $column['column'];

                                $constraint = new ConstraintMetaDataImpl($cols, $constName, 'UNKNOWN');
                                break;
                        }
                    }
                }
            }
        } catch (\blaze\ds\SQLException $e) {
            throw $e;
        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $constraint;
    }

}
?>
