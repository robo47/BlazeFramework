<?php

namespace blaze\persistence;

/**
 * Description of Transaction
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Transaction {

    public function commit();

    public function rollback();
}

?>
