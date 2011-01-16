<?php

namespace blaze\ds\driver\pdomysql\meta;

/**
 * Description of SequenceMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class SequenceMetaDataImpl extends \blaze\ds\driver\pdobase\meta\AbstractSequenceMetaData {

    private $table;
    private $column;

    public function __construct(\blaze\ds\meta\SchemaMetaData $schema, blaze\ds\meta\TableMetaData $table, \blaze\ds\meta\ColumnMetaData $column){
        $this->schema = $schema;
        $this->table = $table;
        $this->column = $column;
    }

    public function drop() {
        $this->schema->dropSequence($this->name);
        return true;
    }

    public function nextValue() {
        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT tbl.AUTO_INCREMENT FROM information_schema.TABLES tbl join information_schema.COLUMNS col ON tbl.TABLE_NAME = col.TABLE_NAME WHERE tbl.TABLE_SCHEMA = ? AND col.EXTRA = \'auto_increment\' AND col.TABLE_NAME = ? AND col.COLUMN_NAME = ?');
        $stmt->setString(0, $this->schema->getSchemaName());
        $stmt->setString(1, $ths->table->getTableName());
        $stmt->setString(2, $this->column->getName());
        $rs = $stmt->executeQuery();

        if($rs->next())
                return $rs->getInt(0);
        return -1;
    }

    public function setCurrentValue($currentValue) {
        $stmt = $this->databaseMetaData->getConnection()->prepareStatement('UPDATE information_schema.TABLES SET AUTO_INCREMENT = ? WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND AUTO_INCREMENT NOT NULL');
        $stmt->setString(0, $currentValue);
        $stmt->setString(1, $this->schema->getSchemaName());
        $stmt->setString(2, $ths->table->getTableName());
        $stmt->executeUpdate();

        return $this;
    }

    /**
     * This method does nothing because the increment in mysql can't be changed for
     * a single table.
     */
    public function setIncrementValue($incrementValue) {
        return $this;
    }

    /**
     * This method does nothing because the precision in mysql can't be changed for
     * auto increment
     */
    public function setPrecision($precision) {
        return $this;
    }

    /**
     * This method does nothing because the sequence type in mysql is always int.
     */
    public function setSequenceClassType($classType) {
        return $this;
    }

    /**
     * This method does nothing because mysql does not support sequences and the
     * name of this virtual sequence is just generated.
     */
    public function setSequenceName($sequenceName) {
        return $this;
    }

    /**
     * This method does nothing because the sequence type in mysql is always int.
     */
    public function setSequenceNativeType($nativeType) {
        return $this;
    }

    public function getCurrentValue() {
        return $this->nextValue() - 1;
    }

    public function getIncrementValue() {
        return 1;
    }

    public function getPrecision() {
        switch($this->column->getNativeType()->toUpperCase()->toNative()){
            case 'TINYINT':
                return 255;
            case 'SMALLINT':
                return 65535;
            case 'MEDIUMINT':
                return 16777215;
            case 'INT':
                return 4294967295;
            case 'BIGINT':
                return 18446744073709551615;
        }
    }

    public function getSequenceClassType() {
        return new \blaze\lang\String('int');
    }

    public function getSequenceName() {
        return \blaze\lang\String::asWrapper($this->table->getTableName().'_'.$this->column->getName().'_seq');
    }

    public function getSequenceNativeType() {
        return $this->column->getNativeType();
    }

}

?>
