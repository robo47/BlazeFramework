<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 blaze\ds\Savepoint;

/**
 * Description of SavepointImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class SavepointImpl extends Object implements Savepoint {

    private $savepointId;
    private $savepointName;

    public function __construct($id, $name) {
        $this->savepointId = $id;
        $this->savepointName = $name;
    }

    public function getSavepointId() {
        return $this->savepointId;
    }

    public function getSavepointName() {
        return $this->savepointName;
    }

}

?>
