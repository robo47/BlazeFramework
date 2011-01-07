<?php

namespace blaze\ds;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\lang\String;

/**
 * The DataSourceManager object can return DataSource objects driver based.
 * Drivers can get registered in and unregistered of the DataSourceManager.
 * The drivers are mapped to a subprotocol of the BDSC-Url.
 *
 * The connection string to a datasource, begins with bdsc (blaze-data-source-connectivity) and is an URL.<br/>
 * The structure looks like this:<br/>
 * bdsc:<driver-protocol>://<Host>[:Port][/DB][?UID=User][&PWD=Password][&Option=Value]...<br/>
 * <br/>
 * Options are driver specific, but "timeout" is a very common one, which specifies the login timeout.
 * Option names are case-insensitive and the order does not matter.<br/>
 * <br/>
 * Example:<br>
 * bdsc:pdomysql://localhost:3306/mydb
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class DataSourceManager extends Object implements Singleton {

    /**
     * The singleton instance.
     *
     * @var blaze\ds\DataSourceManager
     */
    private static $instance;
    /**
     * The login timeout.
     *
     * @var int
     */
    private $timeout = -1;
    /**
     * The available drivers.
     *
     * @var array[\blaze\ds\DataSourceDriver]
     */
    private $drivers = array();

    private function __construct() {
        $this->drivers['pdomysql'] = new \blaze\ds\driver\pdomysql\DataSourceDriverImpl();
    }

    /**
     * Sets the login timeout in seconds.
     *
     * @param int $seconds The timeout in seconds.
     */
    public function setLoginTimeout($seconds) {
        $this->timeout = $seconds;
    }

    /**
     * Returns the login timeout in seconds.
     *
     * @return int The timeout in seconds.
     */
    public function getLoginTimeout() {
        return $this->timeout;
    }

    /**
     * Registers the driver with the give subprotocol in the DataSourceManager.
     *
     * @param string|\blaze\lang\String $protocol The subprotocol for this driver
     * @param \blaze\ds\DataSourceDriver $driver The driver which shall be registered
     */
    public function registerDriver($protocol, \blaze\ds\DataSourceDriver $driver) {
        $this->drivers[String::asNative($protocol)] = $driver;
    }

    /**
     * Returns the login timeout in seconds.
     *
     * @return int The timeout in seconds.
     */
    public function unregisterDriver($protocol) {
        $protocol = String::asNative($protocol);

        if (array_key_exists($protocol, $this->drivers))
            unset($this->drivers[$protocol]);
    }

    /**
     * Returns a DataSourceManager instance which exists only once.
     *
     * @return 	blaze\ds\DataSourceManager A Singleton instance
     * @see 	blaze\ds\DataSource
     */
    public static function getInstance() {
        if (self::$instance == null)
            self::$instance = new DataSourceManager();
        return self::$instance;
    }

    /**
     * Returns a DataSource to a ressource with the given configuration.
     *
     * @param blaze\lang\String|string $dsn The connection string to the datasource.
     * @param blaze\lang\String|string $uid The uid which is used to establish a connection
     * @param blaze\lang\String|string $pwd The password which is used to establish a connection
     * @param \blaze\collections\map\Properties $options Driver specific options.
     * @return blaze\ds\DataSource A datasource object.
     * @throws blaze\ds\DataSourceException Is thrown if a database error occurs.
     */
    public function getDataSource($dsn, $uid = null, $pwd = null, \blaze\collections\map\Properties $options = null) {
        $matches = array();
        $uri = null;
        $url = null;

        try {
            $uri = \blaze\net\URI::parseURI($dsn);
            $url = \blaze\net\URL::parseURL($uri->getSchemeSpecificPart());
        } catch (blaze\lang\Exception $e) {
            throw $e;
        }

        if (!$uri->getScheme()->equalsIgnoreCase('bdsc'))
            throw new DataSourceException('Invalid DSN');

        $driverProtocol = $url->getScheme()->toNative();
        $host = $url->getHost();
        $port = $url->getPort();
        $database = $url->getPath()->trim('/');
        $user = null;
        $password = null;
        if ($options === null)
            $options = new \blaze\collections\map\Properties();

        if (strlen($url->getQuery()) != 0) {
            $optParts = explode('&', $url->getQuery());

            if (count($optParts) != 0) {
                foreach ($optParts as $opt) {
                    $optPair = explode('=', $opt);

                    if (count($optPair) == 2) {
                        if (strcasecmp($optPair[0], 'uid') == 0)
                            $user = $optPair[1];
                        else if (strcasecmp($optPair[0], 'pwd') == 0)
                            $password = $optPair[1];
                        else if (!$options->containsKey($optPair[0]))
                            $options->put($optPair[0], $optPair[1]);
                    }
                }
            }
        }

        if ($uid !== null)
            $user = $uid;
        if ($pwd !== null)
            $password = $pwd;

        $options->put('timeout', $this->timeout);

        if (!array_key_exists($driverProtocol, $this->drivers))
            throw new DataSourceException('No driver found for the given url.');
        return $this->drivers[$driverProtocol]->getDataSource($host, $port, $database, $user, $password, $options);
    }

}

?>
