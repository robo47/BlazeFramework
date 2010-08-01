<?php
namespace blaze\persistence;

/**
 * Description of Session
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Session {
    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\persistence\Transaction Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function beginTransaction();
     public function close();

     /**
      *
      * @param blaze\lang\String|string|blaze\lang\ClassWrapper $class
      * @return blaze\persistence\Criteria
      */
     public function createCriteria($class);
     /**
      *
      * @param blaze\lang\String\string $query
      * @return blaze\persistence\Query
      */
     public function createQuery($query);
     /**
      *
      * @param blaze\lang\String\string $query
      * @return blaze\persistence\SqlQuery
      */
     public function createSqlQuery($query);
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
     public function save($object);
     /**
      *
      * @param blaze\lang\Object $object
      */
     public function saveOrUpdate($object);
     /**
      *
      * @param blaze\lang\Object $object
      */
     public function update($object);
}

?>
