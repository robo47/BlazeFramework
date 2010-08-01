<?php
namespace blaze\ds\driver\pdomysql;
use blaze\lang\Object,
blaze\ds\DataSource,
blaze\ds\driver\pdomysql\ConnectionImpl;

/**
 * Description of DataSourceImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class DataSourceImpl extends Object implements DataSource {

    /**
     *
     * @var string
     */
    private $driver;
    /**
     *
     * @var string
     */
    private $host;
    /**
     *
     * @var integer
     */
    private $port;
    /**
     *
     * @var string
     */
    private $database;
    /**
     *
     * @var string
     */
    private $user;
    /**
     *
     * @var string
     */
    private $password;
    /**
     *
     * @var array
     */
    private $options;

    private function __construct($driver, $host, $port, $database, $user, $password, $options) {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->options = $options;
    }

    public function getConnection($user = null, $password = null, $options = null) {
        if($user != null)
            $this->user = $user;
        if($password != null)
            $this->password = $password;
        if($options != null)
            $this->options = array_merge($this->options, $options);

        return new ConnectionImpl($this->driver, $this->host, $this->port, $this->database, $this->user, $this->password, $this->options);
    }

    public static function getDataSource($host, $port, $database, $user = null, $password = null, $options = null) {
        $driver = 'mysql';
        
        if(!in_array($driver,\PDO::getAvailableDrivers()))
                throw new \blaze\lang\IllegalArgumentException('Driver '.$dirver.' does not exist.');
        if($port == null || $port < 1 || $port > 65536)
            $port = 3306;
        
        return new DataSourceImpl($driver, $host, $port, $database, $user, $password, $options);
    }
}

?>
