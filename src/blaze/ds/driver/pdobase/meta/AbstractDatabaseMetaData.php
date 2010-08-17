<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
blaze\ds\meta\DatabaseMetaData;

/**
 * Description of AbstractDatabaseMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
    protected $user;
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
    
    
}

?>
