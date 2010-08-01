<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractSchemaMetaData;

/**
 * Description of SchemaMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
        }catch(\blaze\ds\SQLException $e){}

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
        }catch(\blaze\ds\SQLException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $table;
    }

}

?>
