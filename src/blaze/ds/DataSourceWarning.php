<?php

namespace blaze\ds;

use blaze\lang\Exception;

/**
 * Warnings which are reported from the datasource end.
 * This object lives as long as it's context lives.
 *
 * Contexts for this warning can be
 * <ul>
 *  <li>Connection</li>
 *  <li>Statement</li>
 *  <li>ResultSet</li>
 * </ul>
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class DataSourceWarning extends DataSourceException {

    /**
     *
     * @return blaze\ds\DataSourceWarning
     */
    public function getNextWarning() {
        return $this->getNextException();
    }

    /**
     *
     * @param blaze\ds\DataSourceWarning $nextWarning
     */
    public function setNextWarning(\blaze\ds\DataSourceWarning $nextWarning) {
        $this->setNextException($nextWarning);
    }

}

?>
