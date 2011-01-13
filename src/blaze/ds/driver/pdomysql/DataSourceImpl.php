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
 * @since   1.0
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
     * @var int
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
    /**
     *
     * @var int
     */
    private $loginTimeout = -1;

    public function __construct($driver, $host, $port, $database, $user, $password, \blaze\collections\map\Properties $options = null) {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->options = $options;

        if($this->options === null)
                $this->options = new \blaze\collections\map\Properties();
    }

    public function getConnection($user = null, $password = null, \blaze\collections\map\Properties $options = null) {
        if ($user === null)
            $user = $this->user;
        if ($password === null)
            $password = $this->password;
        if ($options !== null)
            $options->putAll($this->options);
        else
            $options = new \blaze\collections\map\Properties($this->options);
        if($this->loginTimeout !== -1)
            $options->put('timeout', $this->loginTimeout);

        return new ConnectionImpl($this->driver, $this->host, $this->port, $this->database, $user, $password, $options);
    }

    public function getLoginTimeout() {
        return $this->loginTimeout;
    }

    public function setLoginTimeout($seconds) {
        $this->loginTimeout = $seconds;
    }

}

?>
