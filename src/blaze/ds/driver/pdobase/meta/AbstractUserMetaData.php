<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object;

/**
 * Description of AbstractResultSetMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractUserMetaData extends Object implements \blaze\ds\meta\UserMetaData {

    /**
     *
     * @var blaze\lang\String
     */
    protected $userName;

    public function getUserName() {
        return $this->userName;
    }

}

?>
