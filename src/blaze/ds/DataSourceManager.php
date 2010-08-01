<?php
namespace blaze\ds;
use blaze\lang\Object,
blaze\lang\Singleton,
blaze\lang\String,
blaze\net\URI;

/**
 * Description of DataSourceManager
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
final class DataSourceManager extends Object implements Singleton {

    /**
     *
     * @var blaze\ds\DataSourceManager
     */
    private static $instance;

    private function __construct() {

    }

    /**
     * Returns a DataSourceManager instance which exists only once
     *
     * @return 	blaze\ds\DataSourceManager A Singleton instance
     * @see 	blaze\ds\DataSource
     */
    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new DataSourceManager();
        return self::$instance;
    }

    /**
     * Returns a DataSource to a ressource with the given configuration
     *
     * @param blaze\lang\String|string $dsn The connection string to the datasource, begins with bdsc (blaze-data-source-connectivity) and is an URI<br/>
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
     * @throws blaze\ds\SQLException Is thrown if a database error occurs.
     */
    public function getDataSource($dsn, $uid = null, $pwd = null, $options = null) {
        $matches = array();
        $uri = URI::parseURI($dsn);

        if(preg_match('/bdsc:([a-zA-Z0-9_-]+)/', $uri->getScheme(), $matches) == 0)
            throw new SQLException('Invalid DSN');

        $driver = $matches[1];
        $host = $uri->getHost();
        $port = $uri->getPort();
        $database = $uri->getPath()->trim('/');
        $user = null;
        $password = null;
        $options = array();

        if(strlen($uri->getQuery()) != 0) {
            $optParts = explode('&', $uri->getQuery());

            if(count($optParts) != 0) {
                foreach($optParts as $opt) {
                    $optPair = explode('=', $opt);

                    if(count($optPair) == 2) {
                        if(strcasecmp($optPair[0], 'uid') == 0)
                            $user = $optPair[1];
                        else if(strcasecmp($optPair[0], 'pwd') == 0)
                            $password = $optPair[1];
                        else
                            $options[$optPair[0]] = $optPair[1];
                    }
                }
            }
        }
        
        $className = '\\blaze\\ds\\driver\\'.$driver.'\\DataSourceImpl';
        
        $method = \blaze\lang\ClassWrapper::forName($className)->getMethod('getDataSource');

        if($method == null)
            throw new \blaze\lang\IllegalArgumentException('Driver '.$dirver.' does not exist.');
        
        return $method->invokeArgs(null, array($host, $port, $database, $user, $password, $options));
    }
}

?>
