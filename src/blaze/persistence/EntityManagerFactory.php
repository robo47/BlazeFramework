<?php
namespace blaze\persistence;

/**
 * Description of EntityManagerFactory
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


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
