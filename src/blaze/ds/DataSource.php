<?php

namespace blaze\ds;

/**
 * A DataSource object represents an immutable object which holds connection
 * data to a DataSource end. It can only return Connections to the datasource
 * but for not only the user which is defined in it. It can override the user
 * data or options.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface DataSource {


    /**
     * Sets the login timeout in seconds.
     *
     * @param int $seconds The timeout in seconds.
     */
    public function setLoginTimeout($seconds);

    /**
     * Returns the login timeout in seconds.
     *
     * @return int The timeout in seconds.
     */
    public function getLoginTimeout();

    /**
     * Returns a Connection object connected to the DataSource specified by this object.
     *
     * @param string|\blaze\lang\String $user The user with which you want to connect
     * @param string|\blaze\lang\String  $password The password to the user to connect
     * @param \blaze\collections\map\Properties $options Driver specific options
     * @return 	blaze\ds\Connection Returns a Connection to the specified datasource
     */
    public function getConnection($user = null, $password = null, \blaze\collections\map\Properties $options = null);

}

?>
