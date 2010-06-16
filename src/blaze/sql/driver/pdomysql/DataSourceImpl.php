<?php
namespace blaze\sql\driver\pdomysql;
use blaze\lang\Object,
blaze\sql\DataSource,
blaze\sql\driver\pdomysql\ConnectionImpl;

/**
 * Description of DataSourceImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
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

    private function __construct($driver = null, $host = null, $port = null, $database = null, $user = null, $password = null, $options = null) {
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
        
        return new DataSourceImpl($driver, $host, $port, $database, $user, $password, $options);
    }
}

?>
