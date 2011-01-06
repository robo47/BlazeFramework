<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractSchemaMetaData;

/**
 * Description of SchemaMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SchemaMetaDataImpl extends AbstractSchemaMetaData {

    public function __construct(\blaze\ds\meta\DatabaseMetaData $databaseMetaData, $schemaName, $schemaCharset, $schemaCollation){
        $this->databaseMetaData = $databaseMetaData;
        $this->schemaName = $schemaName;
        $this->schemaCharset = $schemaCharset;
        $this->schemaCollation = $schemaCollation;
    }
    /**
     * @return blaze\ds\meta\DatabaseMetaData
     */
    public function getDatabaseMetaData(){
        return $this->databaseMetaData;
    }
    /**
     * @return blaze\lang\String
     */
    public function getSchemaName(){
        return $this->schemaName;
    }
    /**
     * @return blaze\lang\String
     */
    public function getSchemaCharset(){
        return $this->schemaCharset;
    }
    /**
     * @return blaze\lang\String
     */
    public function getSchemaCollation(){
        return $this->schemaCollation;
    }
    
    /**
     * @return blaze\util\ListI[blaze\ds\meta\TableMetaData]
     */
    public function getTables(){
        $stmt = null;
        $rs = null;
        $tables = array();

        try{
            $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?');
            $stmt->setString(0, $this->schemaName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while($rs->next())
                $tables[] = new TableMetaDataImpl($this, $rs->getString('TABLE_NAME'),
                                                           $rs->getString('TABLE_COMMENT'),
                                                           $this->schemaCharset,
                                                           $rs->getString('TABLE_COLLATION'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $tables;
    }
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable($tableName){
        $stmt = null;
        $rs = null;
        $table = null;

        try{
            $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?');
            $stmt->setString(0, $this->schemaName);
            $stmt->setString(1, $tableName);
            $stmt->execute();
            $rs = $stmt->getResultSet();
            
            if($rs->next())
                $table = new TableMetaDataImpl($this, $rs->getString('TABLE_NAME'),
                                                           $rs->getString('TABLE_COMMENT'),
                                                           $this->schemaCharset,
                                                           $rs->getString('TABLE_COLLATION'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $table;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ViewMetaData]
     */
    public function getViews(){
        $stmt = null;
        $rs = null;
        $views = array();

        try{
            $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.VIEWS WHERE TABLE_SCHEMA = ?');
            $stmt->setString(0, $this->schemaName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while($rs->next())
                $views[] = new ViewMetaDataImpl($this, $rs->getString('TABLE_NAME'),
                                                           $rs->getString('VIEW_DEFINITION'),
                                                           $rs->getString('IS_UPDATEABLE'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $views;
    }
    /**
     * @return blaze\ds\meta\ViewMetaData
     */
    public function getView($viewName){
        $stmt = null;
        $rs = null;
        $view = null;

        try{
            $stmt = $this->databaseMetaData->getConnection()->prepareStatement('SELECT * FROM information_schema.VIEWS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?');
            $stmt->setString(0, $this->schemaName);
            $stmt->setString(1, $viewName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if($rs->next())
                $view = new ViewMetaDataImpl($this, $rs->getString('TABLE_NAME'),
                                                           $rs->getString('VIEW_DEFINITION'),
                                                           $rs->getString('IS_UPDATEABLE'));
        }catch(\blaze\ds\DataSourceException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $view;
    }

    public function addTable(\blaze\ds\meta\TableMetaData $table, $newName = null) {
        $this->checkClosed();
        $table->initialize($this, $newName);
        return $table;
    }

    public function addView(\blaze\ds\meta\ViewMetaData $view, $newName = null) {
        $this->checkClosed();
        if($newName === null)
            $view = $this->createView($view->getViewName(), $view->getViewDefinition());
        else
            $view = $this->createView($newName, $view->getViewDefinition());

        return $view;
    }

    public function createTable($tableName, $charset = null, $collation = null, $comment = null) {
        $this->checkClosed();
        return new TableMetaDataImpl(null, $tableName, $comment, $charset, $collation, false);
    }

    public function createView($viewName, $viewDefinition) {
        $this->checkClosed();
        $query = 'CREATE VIEW '.$viewName.' AS '.$viewDefinition;

        $this->databaseMetaData->getConnection()->createStatement()->executeQuery($query);
        return $this->getView($viewName);
    }

    public function drop() {
        $this->databaseMetaData->drop();
    }

    public function dropTable($tableName) {
        $this->checkClosed();
        $this->databaseMetaData->getConnection()->createStatement()->executeQuery('DROP TABLE '.$tableName);
    }

    public function dropView($viewName) {
        $this->checkClosed();
        $this->databaseMetaData->getConnection()->createStatement()->executeQuery('DROP TABLE '.$viewName);
    }

    public function setSchemaCharset($schemaCharset) {
        $this->databaseMetaData->setDatabaseCharset($schemaCharset);
    }

    public function setSchemaCollation($schemaCollation) {
        $this->databaseMetaData->setDatabaseCollation($schemaCollation);
    }

    public function setSchemaName($schemaName) {
        $this->databaseMetaData->setDatabaseName($schemaName);
    }

}

?>
