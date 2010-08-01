<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\lang\Object,
blaze\ds\driver\pdobase\meta\AbstractDatabaseMetaData;

/**
 * Description of DatabaseMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class DatabaseMetaDataImpl extends AbstractDatabaseMetaData {
    
    public function __construct(\blaze\ds\Connection $con, \PDO $pdo, $host, $port, $database, $user, $options) {
        $this->con = $con;
        $this->pdo = $pdo;
        $this->user = $user;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->options = $options;
        $this->driverName = new \blaze\lang\String('pdomysql');
        $this->driverVersion = new \blaze\lang\String('0.1');
        $this->databaseProductName = new \blaze\lang\String('MySQL');
        $this->databaseProductVersion = new \blaze\lang\String($this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION));
    }

    /**
     * @return blaze\ds\Connection
     */
    public function getConnection(){
        return $this->con;
    }
    /**
     * @return blaze\lang\String
     */
    public function getHost(){
        return $this->host;
    }
    /**
     * @return blaze\lang\String
     */
    public function getPort(){
        return $this->port;
    }
    /**
     * @return array
     */
    public function getOptions(){
        return $this->options;
    }
    /**
     * @return blaze\lang\String
     */
    public function getDatabaseName(){
        return $this->database;
    }
    /**
     * @return blaze\lang\String
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDatabaseProductName(){
        return $this->databaseProductName;
    }
    /**
     * @return blaze\lang\String
     */
    public function getDatabaseProductVersion(){
        return $this->databaseProductVersion;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDriverName(){
        return $this->driverName;
    }
    /**
     * @return blaze\lang\String
     */
    public function getDriverVersion(){
        return $this->driverVersion;
    }

    /**
     * @return blaze\util\ListI[blaze\ds\meta\SchemaMetaData]
     */
    public function getSchemas(){
        $stmt = null;
        $rs = null;
        $schemas = array();

        try{
            $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA');
            $stmt->execute();
            $rs = $stmt->getResultSet();
            
            while($rs->next())
                $schemas[] = new SchemaMetaDataImpl($this, $rs->getString('SCHEMA_NAME'),
                                                           $rs->getString('DEFAULT_CHARACTER_SET_NAME'),
                                                           $rs->getString('DEFAULT_COLLATION_NAME'));
        }catch(\blaze\ds\SQLException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $schemas;
    }
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema($schemaName){
        $stmt = null;
        $rs = null;
        $schema = null;

        try{
            $stmt = $this->con->prepareStatement('SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?');
            $stmt->setString(0, $schemaName);
            $stmt->execute();
            $rs = $stmt->getResultSet();

            if($rs->next())
                $schema = new SchemaMetaDataImpl($this, $rs->getString('SCHEMA_NAME'),
                                                         $rs->getString('DEFAULT_CHARACTER_SET_NAME'),
                                                         $rs->getString('DEFAULT_COLLATION_NAME'));
        }catch(\blaze\ds\SQLException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $schema;
    }
}

?>
