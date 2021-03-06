<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\DatabaseMetaData;

/**
 * Description of AbstractDatabaseMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractDatabaseMetaData extends Object implements DatabaseMetaData {

    /**
     *
     * @var blaze\ds\Connection
     */
    protected $con;
    /**
     *
     * @var \PDO 
     */
    protected $pdo;
    /**
     *
     * @var blaze\lang\String
     */
    protected $username;
    /**
     *
     * @var blaze\lang\String
     */
    protected $host;
    /**
     *
     * @var int
     */
    protected $port;
    /**
     *
     * @var blaze\lang\String
     */
    protected $database;
    /**
     *
     * @var array
     */
    protected $options;
    /**
     *
     * @var blaze\lang\String
     */
    protected $driverName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $driverVersion;
    /**
     *
     * @var blaze\lang\String
     */
    protected $databaseProductName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $databaseProductVersion;

    public function dropSchemaIfExists($schemaName) {
        try {
            $this->dropSchema($schemaName);
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function checkClosed() {
        if ($this->con->isClosed())
            throw new DataSourceException('Connection is already closed.');
    }

}

?>
