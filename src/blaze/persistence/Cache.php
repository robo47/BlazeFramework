<?php
namespace blaze\persistence;

/**
 * Description of EntityManager
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
