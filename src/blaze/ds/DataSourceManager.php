<?php

namespace blaze\ds;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\lang\String;

/**
 * Description of DataSourceManager
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
final class DataSourceManager extends Object implements Singleton {

    /**
     *
     * @var blaze\ds\DataSourceManager
     */
    private static $instance;
    private $timeout = 0;

    private function __construct() {

    }

    /**
     * @param int $seconds
     */
    public function setLoginTimeout($seconds) {
        $this->timeout = $seconds;
    }

    /**
     *
     * @return int
     */
    public function getLoginTimeout() {
        return $this->timeout;
    }

    /**
     * Returns a DataSourceManager instance which exists only once
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
     * Returns a DataSource to a ressource with the given configuration
     *
     * @param blaze\lang\String|string $dsn The connection string to the datasource, begins with bdsc (blaze-data-source-connectivity) and is an URL<br/>
     *                                      Structure:<br/>
     *                                      bdsc:<gateway>:<driver-name>://<Host>[:Port][/DB][?UID=User][&PWD=Password][&Option=Value]...<br/>
     *                                      <br/>
     *                                      Currently there are the following gateways, each of them have their own drivers:<br/>
     *                                      <ul>
     *                                         <li>native - Native PHP libraries(e.g. see mysql_connect())</li>
     *                                         <li>pdo - All available PDO-Drivers</li>
     *                                      </ul><br/>
     *                                      Options are driver specific. Option names are caseinsensitive and the order does not matter.<br/>
     *                                      <br/>
     *                                      Example:<br>
     *                                      bdsc:pdo:mysql://localhost:3306/mydb
     * @param blaze\lang\String|string $uid The uid which is used to establish a connection
     * @param blaze\lang\String|string $pwd The password which is used to establish a connection
     * @param array $options Driver specific options.
     * @return blaze\ds\DataSource A Datasource to the given dsn.
     * @throws blaze\ds\DataSourceException Is thrown if a database error occurs.
     */
    public function getDataSource($dsn, $uid = null, $pwd = null, $options = null) {
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

        $driver = $url->getScheme();
        $host = $url->getHost();
        $port = $url->getPort();
        $database = $url->getPath()->trim('/');
        $user = null;
        $password = null;
        $options1 = array();

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
                        else
                            $options1[$optPair[0]] = $optPair[1];
                    }
                }
            }
        }

        if ($uid !== null)
            $user = $uid;
        if ($pwd !== null)
            $password = $pwd;
        if ($options !== null)
            $options1 = $options;

        $className = '\\blaze\\ds\\driver\\' . $driver . '\\DataSourceImpl';

        $method = \blaze\lang\ClassWrapper::forName($className)->getMethod('getDataSource');

        if ($method == null)
            throw new \blaze\lang\IllegalArgumentException('Driver ' . $dirver . ' does not exist.');
        $ds = $method->invokeArgs(null, array($host, $port, $database, $user, $password, $options));
        $ds->setLoginTimeout($this->timeout);
        return $ds;
    }

}

?>
