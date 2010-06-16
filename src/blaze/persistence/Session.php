<?php
namespace blaze\persistence;

/**
 * Description of Session
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface Session {
    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\persistence\Transaction Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
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
