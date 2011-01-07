<?php

namespace blaze\ds;

/**
 * Description of DataSource
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface DataSource {

    /**
     * @param int $seconds
     */
    public function setLoginTimeout($seconds);

    /**
     * @return int
     */
    public function getLoginTimeout();

    /**
     *
     * @param <type> $user
     * @param <type> $password
     * @param <type> $options
     * @return 	blaze\ds\Connection Description of what the method returns
     */
    public function getConnection($user = null, $password = null, $options = null);

    /**
     *
     * @param <type> $driver
     * @param <type> $host
     * @param <type> $port
     * @param <type> $database
     * @param <type> $user
     * @param <type> $password
     * @param <type> $options
     * @return blaze\ds\DataSource
     */
    public static function getDataSource($host, $port, $database, $user = null, $password = null, $options = null);
}

?>
