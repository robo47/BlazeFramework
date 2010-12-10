<?php
namespace blaze\persistence;

/**
 * Description of EntityManagerFactory
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface EntityManagerFactory extends \blaze\io\Closeable{
    /**
     *
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $class
     * @return blaze\persistence\meta\ClassDescriptor
     */
    public function getClassDescriptor($class);
    /**
     *
     * @return blaze\collections\ListI[blaze\persistence\meta\ClassDescriptor]
     */
    public function getClassDescriptors();
    /**
     * Returns a new EntityManager
     *
     * @return 	blaze\persistence\EntityManager
     */
     public function createEntityManager();
}

?>
