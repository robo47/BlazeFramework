<?php
namespace blaze\persistence;

/**
 * Description of EntityManager
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface EntityManager {

    /**
     * @return blaze\ds\Connection
     */
    public function getConnection();
    /**
     * @return blaze\persistence\EntityManagerFactory
     */
    public function getEntityManagerFactory();
     public function beginTransaction();
     public function commit();
     public function close();

     /**
      *
      * @param blaze\lang\String|string|blaze\persistence\ooql\Statement $query
      * @return blaze\persistence\Query
      */
     public function createQuery($queryOrStatement);
     /**
      *
      * @param blaze\lang\String\string $query
      * @return blaze\persistence\NativeQuery
      */
     public function createNativeQuery($query);
     /**
      *
      * @param blaze\lang\String|string|blaze\lang\ClassWrapper $class
      * @param mixed $id
      */
     public function get($class, $id);

     /**
      *
      * @param blaze\lang\Object $object
      */
     public function save(\blaze\lang\Object $object);
     /**
      *
      * @param blaze\lang\Object $object
      */
     public function saveOrUpdate(\blaze\lang\Object $object);
     /**
      *
      * @param blaze\lang\Object $object
      */
     public function update(\blaze\lang\Object $object);
     /**
      *
      * @param blaze\lang\Object $object
      */
     public function remove(\blaze\lang\Object $object);
     /**
      *
      * @param blaze\lang\String|string|blaze\lang\ClassWrapper $class
      * @param blaze\collections\ListI $ids
      */
     public function removeByIds($class, \blaze\collections\ListI $ids);
}

?>
