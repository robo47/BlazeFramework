<?php

namespace blaze\ds;

/**
 * This is a driver for datasources which can be registered in the DataSourceManager
 * to a subprotocol. It provides a method to get a DataSource object.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface DataSourceDriver {

    /**
     * Returns a new DataSource object configured with the given parameters.
     *
     * @param string|\blaze\lang\String $host The host on which the datasource end is running
     * @param int $port The port on which the datasource end is running
     * @param string|\blaze\lang\String $objectName The name of the datasource object to which you want to connect
     * @param string|\blaze\lang\String $user The user with which you want to connect
     * @param string|\blaze\lang\String  $password The password to the user to connect
     * @param \blaze\collections\map\Properties $options Driver specific options
     * @return 	blaze\ds\DataSource Returns a Connection to the specified datasource
     */
    public function getDataSource($host, $port, $objectName, $user = null, $password = null, \blaze\collections\map\Properties $options = null);

}

?>
