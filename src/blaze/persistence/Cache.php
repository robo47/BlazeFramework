<?php

namespace blaze\persistence;

/**
 * Description of EntityManager
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface Cache {

    /**
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $class
     * @param mixed $identifier
     * @return boolean
     */
    public function contains($class, $identifier);

    /**
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $class
     * @param mixed $identifier
     */
    public function evict($class, $identifier = null);

    public function evictAll();
}

?>
