<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 blaze\ds\DataSourceDriver,
 blaze\ds\driver\pdomysql\ConnectionImpl;

/**
 * Description of DataSourceDriverImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class DataSourceDriverImpl extends Object implements DataSourceDriver {

    public function __construct(){
        if (!in_array('mysql', \PDO::getAvailableDrivers()))
            throw new \blaze\lang\IllegalArgumentException('Driver ' . $dirver . ' does not exist.');
    }

    public function getDataSource($host, $port, $database, $user = null, $password = null, \blaze\collections\map\Properties $options = null) {
        if ($port === null || $port < 1 || $port > 65536)
            $port = 3306;
        return new DataSourceImpl('mysql', $host, $port, $database, $user, $password, $options);
    }

}

?>
