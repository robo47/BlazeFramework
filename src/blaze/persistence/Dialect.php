<?php

namespace blaze\persistence;

/**
 * Description of EntityManager
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Dialect {
    public function getNativeQuery(\blaze\persistence\ooql\Statement $stmt, \blaze\persistence\EntityManager $em);
}

?>
