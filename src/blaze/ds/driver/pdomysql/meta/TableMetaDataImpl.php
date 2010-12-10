<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractTableMetaData;

/**
 * Description of TableMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class TableMetaDataImpl extends AbstractTableMetaData{

    public function __construct(\blaze\ds\meta\SchemaMetaData $schema, $tableName, $tableComment, $tableCharset, $tableCollation){
        $this->schema = $schema;
        $this->tableName = $tableName;
        $this->tableComment = $tableComment;
        $this->tableCharset = $tableCharset;
        $this->tableCollation = $tableCollation;
    }

    /**
     * @return blaze\lang\String
     */
    public function getTableName(){
        return $this->tableName;
    }
    /**
     * @return blaze\lang\String
     */
    public function getTableComment(){
        return $this->tableComment;
    }
    /**
     * @return blaze\lang\String
     */
    public function getTableCharset(){
        return $this->tableCharset;
    }
    /**
     * @return blaze\lang\String
     */
    public function getTableCollation(){
        return $this->tableCollation;
    }
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema(){
        return $this->schema;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns(){
        $stmt = null;
        $rs = null;
        $columns = array();

        try{
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while($rs->next())
                $columns[] = new ColumnMetaDataImpl($this, $rs->getString('COLUMN_NAME'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $columns;
    }
    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getColumn($columnName){
        
        $stmt = null;
        $rs = null;
        $column = null;

        try{
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->setString(2, $columnName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if($rs->next())
                $column = new ColumnMetaDataImpl($this, $rs->getString('COLUMN_NAME'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $column;
    }
    /**
     * @return blaze\util\ListI[blaze\ds\meta\TriggerMetaData]
     */
    public function getTriggers(){
        $stmt = null;
        $rs = null;
        $triggers = array();

        try{
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while($rs->next())
                $triggers[] = new TriggerMetaDataImpl($this, $rs->getString('ACTION_TIMING'),
                                                            $rs->getString('EVENT_MANIPULATION'),
                                                            $rs->getString('ACTION_ORDER'),
                                                            $rs->getString('TRIGGER_NAME'),
                                                            $rs->getString('ACTION_STATEMENT'),
                                                            $rs->getString('ACTION_REFERENCE_OLD_ROW'),
                                                            $rs->getString('ACTION_REFERENCE_NEW_ROW'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $triggers;
    }
    /**
     * @return blaze\ds\meta\TriggerMetaData
     */
    public function getTrigger($triggerName){
        $stmt = null;
        $rs = null;
        $trigger = array();

        try{
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ? AND TRIGGER_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->setString(1, $triggerName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if($rs->next())
                $trigger = new TriggerMetaDataImpl($this, $rs->getString('ACTION_TIMING'),
                                                            $rs->getString('EVENT_MANIPULATION'),
                                                            $rs->getString('ACTION_ORDER'),
                                                            $rs->getString('TRIGGER_NAME'),
                                                            $rs->getString('ACTION_STATEMENT'),
                                                            $rs->getString('ACTION_REFERENCE_OLD_ROW'),
                                                            $rs->getString('ACTION_REFERENCE_NEW_ROW'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $trigger;
    }
    /**
     * @return blaze\util\ListI[blaze\ds\meta\IndexMetaData]
     */
    public function getIndizes(){
        $stmt = null;
        $rs = null;
        $indizes = array();

        try{
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SHOW INDEX FROM '.$this->schema->getSchemaName().'.'.$this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while($rs->next())
                $indizes[] = new IndexMetaDataImpl($this, $rs->getString('Key_Name'),
                                                          !$rs->getBoolean('Non_unique'),
                                                          $rs->getString('Null')->equalsIgnoreCase('YES'),
                                                          $rs->getString('Index_type'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $indizes;
    }
    /**
     * @return blaze\ds\meta\IndexMetaData
     */
    public function getIndex($indexName){
        $stmt = null;
        $rs = null;
        $index = null;

        try{
            $stmt = $this->schema
                         ->getDatabaseMetaData()
                         ->getConnection()
                         ->prepareStatement('SHOW INDEX FROM '.$this->schema->getSchemaName().'.'.$this->tableName.' WHERE Key_name = \''.\blaze\lang\String::asNative($indexName).'\'');
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if($rs->next())
                $index = new IndexMetaDataImpl($this, $rs->getString('Key_name'),
                                                      !$rs->getBoolean('Non_unique'),
                                                      $rs->getString('Null')->equalsIgnoreCase('YES'),
                                                      $rs->getString('Index_type'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $index;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getPrimaryKeys(){
        $arr = array();
        $cols = $this->getColumns();
        
        for($i = 0; $i < count($cols); $i++)
            if($cols[$i]->isPrimaryKey())
                    $arr[] = $cols[$i];
        return $arr;
    }
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getForeignKeys(){
        $arr = array();
        $cols = $this->getColumns();
        
        for($i = 0; $i < count($cols); $i++)
            if($cols[$i]->isForeignKey())
                    $arr[] = $cols[$i];
        return $arr;
    }
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getUniqueKeys(){
        $arr = array();
        $cols = $this->getColumns();
        
        for($i = 0; $i < count($cols); $i++)
            if($cols[$i]->isUniqueKey())
                    $arr[] = $cols[$i];
        return $arr;
    }
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getReferencingKeys(){
        $stmt = null;
        $rs = null;
        $columns = array();

        try{
            $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = ? AND REFERENCED_TABLE_NAME = ?');
            $stmt->setString(0, $this->schema->getSchemaName());
            $stmt->setString(1, $this->tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while($rs->next())
                $columns[] = new ColumnMetaDataImpl($this->getSchema()
                                                         ->getDatabaseMetaData()
                                                         ->getSchema($rs->getString('TABLE_SCHEMA'))
                                                         ->getTable($rs->getString('TABLE_NAME')), $rs->getString('COLUMN_NAME'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $columns;
    }

    public function addColumn(\blaze\ds\meta\ColumnMetaData $column) {

    }

    public function addIndex($index) {

    }

    public function addTrigger(\blaze\ds\meta\TriggerMetaData $trigger) {

    }

    public function createColumn($columnName, $columnClass, $columnLength = null, $columnPrecision = null, $columnDefault = null, $columnComment = null, $nullable = true, $primaryKey = false, $uniqueKey = false) {

    }

    public function createIndex($indexName, \blaze\collections\ListI $columns, $structure = IndexMetaData::STRUCTURE_UNKNOWN, $type = IndexMetaData::TYPE_NONE){

    }

    public function createTrigger($triggerName, $triggerDefinition, $triggerTiming, $triggerEvent, $triggerOrder = null, $triggerOldName = null, $triggerNewName = null) {

    }

    public function drop() {

    }

    public function dropColumn($columnName) {

    }

    public function dropIndex($indexName) {

    }

    public function dropTrigger($triggerName) {

    }

    public function setTableCharset($tableCharset) {

    }

    public function setTableCollation($tableCollation) {

    }

    public function setTableComment($tableComment) {

    }

    public function setTableName($tableName) {

    }

}

?>
