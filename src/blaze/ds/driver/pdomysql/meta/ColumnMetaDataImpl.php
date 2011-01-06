<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractColumnMetaData;

/**
 * Description of ColumnMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ColumnMetaDataImpl extends AbstractColumnMetaData {

    public function __construct(\blaze\ds\meta\TableMetaData $table = null, $columnName = null, $columnType = null, $columnLength = null, $columnPrecision = null, $columnDefault = null, $columnComment = null, $nullable = true, $primaryKey = false, $uniqueKey = false, $initialized = true) {
        $this->table = $table;
        $this->name = \blaze\lang\String::asWrapper($columnName);
        if($initialized)
            $this->getColumnInfo();
        else{
            $this->classType = $columnType;
            $this->nativeType = $this->getNativeName($columnType);
            $this->length = $columnLength;
            $this->precision = $columnPrecision;
            $this->default = $columnDefault;
            $this->comment = $columnComment;
            $this->nullable = $nullable;
            $this->primaryKey = $primaryKey;
            $this->uniqueKey = $uniqueKey;
        }
    }

    public function initialize(\blaze\ds\meta\TableMetaData $table){
        $this->table = $table;
        $this->getColumnInfo();
    }

    /**
     * Map the database specific type names to class names.
     *
     * @return blaze\lang\String
     */
    private function getClassName($nativeName, $length) {
        $className = null;
        switch (\blaze\lang\String::asNative($nativeName->toLowerCase())) {
            case 'bigint':  $className = 'blaze\\math\\BigInteger';
                break;
            case 'real':
            case 'double': $className = 'double';
                break;
            case 'float': $className = 'float';
                break;
            case 'numeric':
            case 'decimal': $className = 'blaze\\math\\BigDecimal';
                break;
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'int': $className = 'int';
                break;
            case 'date':
            case 'datetime':
            case 'time':
            case 'timestamp': $className = 'blaze\\util\\Date';
                break;
            case 'blob': $className = 'blaze\\ds\\type\\Blob';
                break;
            default: $className = 'blaze\\lang\\String';
                break;
        }
        return new \blaze\lang\String($className);
    }
    
    /**
     * Map the class names to database specific type names.
     *
     * @return string
     */
    private function getNativeName($className) {
        switch (\blaze\lang\String::asNative($className)) {
            case 'blaze\\math\\BigInteger':
                return 'bigint';
            case 'double':
                return 'double';
            case 'float':
                return 'float';
            case 'blaze\\math\\BigDecimal':
                return 'decimal';
            case 'int':
                return 'int';
            case 'blaze\\util\\Date':
                return 'date';
            case 'blaze\\ds\\type\\Blob':
                return 'blob';
            case 'blaze\\lang\\String':
                return 'varchar';
        }
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
        $stmt->setString(2, $this->name);
        $stmt->execute();
        $rs = $stmt->getResultSet();
        $rs->next();

        $this->default = $rs->getString('COLUMN_DEFAULT');
        $this->nullable = \blaze\lang\String::compare($rs->getString('IS_NULLABLE'), 'YES') == 0;
        $this->nativeType = $rs->getString('DATA_TYPE');
        $this->length = $rs->getInt('NUMERIC_SCALE');
        $this->classType = $this->getClassName($this->nativeType, $this->length);

        if ($this->length == null)
            $this->length = $rs->getInt('CHARACTER_MAXIMUM_LENGTH');

        $this->precision = $rs->getInt('NUMERIC_PRECISION');
        $this->signed = !$rs->getString('COLUMN_TYPE')->contains('unsigned');
        $extra = $rs->getString('EXTRA');
        $this->autoIncrement = $extra != null ? $extra->contains('auto_increment') : false;
        $this->comment = $rs->getString('COLUMN_COMMENT');

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
        $stmt->setString(2, $this->name);
        $stmt->execute();
        $rs = $stmt->getResultSet();

        while($rs->next()){
            if($rs->getString('REFERENCED_TABLE_SCHEMA') != null){
                $this->foreignKey = true;
                break;
            }
        }
        $rs->close();
        $stmt->close();
    }

    public function getComposedNativeType(){
        $type = $this->getNativeType();

        switch (\blaze\lang\String::asNative($type)) {
            case 'bigint':
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'int':
                $type .= '('.$this->getLength().')'.$this->isSigned() ? '' : 'UNSIGNED';
                break;
            case 'char':
            case 'varchar':
            case 'binary':
                $type .= '('.$this->getLength().')';
                break;
            case 'real':
            case 'double':
            case 'float':
            case 'numeric':
            case 'decimal':
                $type .= '('.$this->getLength().','.$this->getPrecision().')';
                break;
        }

        return \blaze\lang\String::asWrapper($type);
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setNativeType($nativeType) {
        $this->nativeType = $nativeType;
    }

    public function setClassType($classType) {
        $this->classType = $classType;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function setPrecision($precision) {
        $this->precision = $precision;
    }

    public function setDefault($default) {
        $this->default = $default;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setNullable($nullable) {
        $this->nullable = $nullable;
    }

    public function setAutoIncrement($autoIncrement) {
        $this->autoIncrement = $autoIncrement;
    }

    public function setSigned($signed) {
        $this->signed = $signed;
    }

    public function setPrimaryKey($primaryKey, $name) {
        $this->primaryKey = $primaryKey;
    }

    public function setForeignKey($foreignKey, $name, \blaze\ds\meta\ColumnMetaData $referencingColumn) {
        $this->foreignKey = $foreignKey;
    }

    public function setUniqueKey($uniqueKey, $name) {
        $this->uniqueKey = $uniqueKey;
    }

    public function setTable(\blaze\ds\meta\TableMetaData $table) {
        $this->table = $table;
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
                $tblConst[$rs->getString('CONSTRAINT_NAME')->toString()] = $rs->getString('CONSTRAINT_TYPE');

            if ($stmt != null)
                $stmt->close();
            if ($rs != null)
                $rs->close();

            $stmt = $this->table->getSchema()->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?');
            $stmt->setString(0, $this->table->getSchema()->getSchemaName());
            $stmt->setString(1, $this->table->getTableName());
            $stmt->setString(2, $this->name);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next()) {
                switch ($tblConst[$rs->getString('CONSTRAINT_NAME')->toString()]) {
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
        } catch (\blaze\ds\DataSourceException $e) {
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
                $tblConst[$rs->getString('CONSTRAINT_NAME')->toString()]['type'] = $rs->getString('CONSTRAINT_TYPE');
                $tblConst[$rs->getString('CONSTRAINT_NAME')->toString()]['columns'][] = array('column' => $this->table->getColumn($rs->getString('COLUMN_NAME')),
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
        } catch (\blaze\ds\DataSourceException $e) {
            throw $e;
        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $constraint;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getReferencingColumns() {
        $stmt = null;
        $rs = null;
        $columns = array();

        try {
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = ? AND REFERENCED_TABLE_NAME = ? AND REFERENCED_COLUMN_NAME = ?');
            $stmt->setString(0, $this->table->getSchema()->getSchemaName());
            $stmt->setString(1, $this->table->getTableName());
            $stmt->setString(2, $this->name);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while ($rs->next())
                $columns[] = new ColumnMetaDataImpl($this->table->getSchema()
                                        ->getDatabaseMetaData()
                                        ->getSchema($rs->getString('TABLE_SCHEMA'))
                                        ->getTable($rs->getString('TABLE_NAME')), $rs->getString('COLUMN_NAME'));
        } catch (\blaze\ds\DataSourceException $e) {

        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $columns;
    }

    public function drop() {
        
    }

}

?>
