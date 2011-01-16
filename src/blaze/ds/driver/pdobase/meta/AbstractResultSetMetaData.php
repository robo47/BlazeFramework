<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\ResultSetMetaData;

/**
 * Description of AbstractResultSetMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractResultSetMetaData extends Object implements ResultSetMetaData {

    /**
     *
     * @var blaze\ds\ResultSet
     */
    protected $resultSet;

    /**
     * @return blaze\ds\ResultSet
     */
    public function getResultSet() {
        return $this->resultSet;
    }

}

?>
