<?php

namespace blaze\persistence\query;

use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class QueryImpl extends Object implements \blaze\persistence\Query {

    private $em;
    private $query;
    private $stmt;
    private $rsd;
    private $timeout = 0;
    private $type;
    private $dialect;
    private $hydrator;

    /**
     *
     * @param \blaze\persistence\EntityManager $em
     * @param \blaze\persistence\Dialect $dialect
     * @param string|\blaze\lang\String|\blaze\persistence\ooql\Statement $query
     */
    public function __construct(\blaze\persistence\EntityManager $em, \blaze\persistence\Dialect $dialect, $query) {
        $this->em = $em;
        $this->dialect = $dialect;
        $this->query = $query;
        
        $this->rsd = $this->buildResultSetDescriptor($query);
    }

    /**
     *
     * @return \blaze\ds\ResultSet
     */
    private function processQuery(){
        $this->stmt = $this->em->getConnection()->prepareStatement($this->dialect->getNativeQuery($this->query, $this->em));
        return $this->stmt->executeQuery();
    }

    /**
     *
     * @param string|\blaze\lang\String|\blaze\persistence\ooql\Statement $query
     * @return \blaze\persistence\meta\ResultSetDescriptor
     */
    private function buildResultSetDescriptor($query){
        $rsd = null;

        //if($query instanceof \blaze\persistence\ooql\Statement)
        if($query instanceof \blaze\persistence\ooql\FromStatement){
            $fromables = $query->getFromClause()->getFromables();
            $aliasMapping = array();
            // Fields which will occur in the ResultSet
            $fields = array();
            $collectionFields = array();
            // Just to check for name duplicates
            $fieldsGlobal = array();

            if(count($fromables) < 1)
                throw new \Exception('Invalid Query, nothing set in the from-clause!');

            // This loop is to check if there are any name duplicates
            // and to set up a alias to field mapping
            foreach($fromables as $fromable){
                if($fromable instanceof \blaze\persistence\ooql\Entity){
                    $classMeta = $this->em->getEntityManagerFactory()->getClassDescriptor($fromable->getName());

                    if($classMeta === null)
                        throw new \blaze\lang\Exception('Entity "'.$fromable->getName().'" does not exist!');

                    if($fromable->getAlias() !== null){
                        $alias = \blaze\lang\String::asNative($fromable->getAlias());
                        if(array_search($alias, $aliasMapping) !== false)
                                    throw new \blaze\lang\Exception('The alias '.$alias.' already exists!');
                        $aliasMapping[$alias] = $classMeta;

                        foreach($classMeta->getIdentifiers() as $field){
                            $fields[$alias][] = $field->getFieldDescriptor();
                        }
                        foreach($classMeta->getSingleFields() as $field){
                            $fields[$alias][] = $field;
                        }
                        foreach($classMeta->getCollectionFields() as $field){
                            $collectionFields[$alias][] = $field;
                        }
                    }else{
                        $alias = \blaze\lang\String::asNative($fromable->getName());
                        if(array_search($alias, $aliasMapping) !== false)
                                    throw new \blaze\lang\Exception('The alias '.$alias.' already exists!');
                        $aliasMapping[$alias] = $classMeta;

                        foreach($classMeta->getIdentifiers() as $field){
                            $val = $field->getFieldDescriptor();
                            if(array_search($val->getName(), $fieldsGlobal) !== false)
                                    throw new \blaze\lang\Exception('The attribute '.$val->getName().' of '.$classMeta->getName().' is already in the global scope, you need to use a alias!');
                            $fieldsGlobal[] = $val->getName();
                            $fields[$alias][] = $val;
                        }
                        foreach($classMeta->getSingleFields() as $field){
                            $val = $field;
                            if(array_search($val->getName(), $fieldsGlobal) !== false)
                                    throw new \blaze\lang\Exception('The attribute '.$val->getName().' of '.$classMeta->getName().' is already in the global scope, you need to use a alias!');
                            $fieldsGlobal[] = $val->getName();
                            $fields[$alias][] = $val;
                        }
                        foreach($classMeta->getCollectionFields() as $field){
                            $val = $field->getFieldDescriptor();
                            if(array_search($val->getName(), $fieldsGlobal) !== false)
                                    throw new \blaze\lang\Exception('The attribute '.$val->getName().' of '.$classMeta->getName().' is already in the global scope, you need to use a alias!');
                            $fieldsGlobal[] = $val->getName();
                            $collectionFields[$alias][] = $field;
                        }
                    }
                }else if($fromable instanceof \blaze\persistence\ooql\Join){
                    // Not supported at the moment
                }else if($fromable instanceof \blaze\persistence\ooql\Subselect){
                    // Not supported at the moment
                }
            }

            if($query instanceof \blaze\persistence\ooql\SelectStatement){
                $clause = $query->getSelectClause();
                $selectables = $clause->getSelectables();
                $selectFields = array();

                if(count($selectables) < 1)
                    throw new \blaze\lang\Exception('Nothing to select given!');

                foreach($selectables as $selectable){

                }

                if(count($selectables) == 1){
                    // Check the selectable to be able to set the return class
                    if($selectables[0] instanceof \blaze\persistence\ooql\Formula){
                        $rsd = new \blaze\persistence\meta\ResultSetDescriptor($selectables[0]->getReturnType());
                    }else{
                        $propNameParts = \blaze\lang\String::asWrapper($selectables[0]->getPropertyName())->split('.');
                        $alias = $propNameParts[count($propNameParts) - 1];

                        if($selectables[0]->getPropertyAlias() !== null)
                            $alias = $selectables[0]->getPropertyAlias();

                        $propPath = new \blaze\persistence\meta\PropertyPath();

                        // Check every field if the name is equal to the selectable
                        foreach($fields as $fieldGroup){
                            foreach($fieldGroup as $field){
                                if($field instanceof \blaze\persistence\meta\SingleFieldDescriptor){
                                    if($field->getName()->compare($propNameParts[0]) == 0){
                                            $rsd = new \blaze\persistence\meta\ResultSetDescriptor($field->getType());
                                            break;
                                    }
                                }else{
                                    if($field->getFieldDescriptor()->getName()->compare($propNameParts[0]) == 0){
                                        // Collection
                                        //$rsd = new \blaze\persistence\meta\ResultSetDescriptor($field->getType());
                                        break;
                                    }
                                }
                            }

                            if($rsd !== null)
                                break;
                        }

                    }
                }else{
                    // Return class is an Object[]
                    $rsd = new \blaze\persistence\meta\ResultSetDescriptor('blaze\\lang\\Object', true);
                }
            }else if(count($fromables) > 1){
               throw new \blaze\lang\Exception('You need to specify what to select!');
            }else{
                // Assume that the only object in fromables has to be selected
                $classDesc = $aliasMapping[\blaze\lang\String::asNative($fromables[0]->getAlias())];
                $rsd = new \blaze\persistence\meta\ResultSetDescriptor($classDesc->getFullName());

                foreach($fields[\blaze\lang\String::asNative($fromables[0]->getAlias())] as $field){
                    $rsd->addFieldMapping($field);
                }
                foreach($collectionFields[\blaze\lang\String::asNative($fromables[0]->getAlias())] as $field){
                    $rsd->addCollectionMapping($field);
                }
            }
        }

        return $rsd;
    }

    public function getList() {
        $this->hydrator = new \blaze\persistence\hydration\ObjectHydrator($this->processQuery(), $this->rsd);
        return \blaze\collections\Arrays::asList($this->hydrator->hydrateAll());
    }

    public function getUniqueResult() {
        $iter = new \blaze\persistence\hydration\ObjectHydratorIterator($this->processQuery(), $this->rsd);

        if(!$iter->hasNext())
                return null;

        $result = $iter->next;

        if($iter->hasNext())
                throw new \blaze\lang\Exception('Non-unique Result');

        return $result;
    }

    public function executeUpdate() {

    }

    public function getQueryString() {
        return $this->query;
    }

    public function getTimeout() {
        return $this->timeout;
    }

    public function getType() {
        return $this->type;
    }

    public function setTimeout($seconds) {
        $this->timeout = $seconds;
    }

    public function setBlob($identifier, \blaze\ds\type\Blob $value) {
        $this->stmt->setBlob($identifier, $value);
    }

    public function setBoolean($identifier, $value) {
        $this->stmt->setBoolean($identifier, $value);
    }

    public function setByte($identifier, $value) {
        $this->stmt->setByte($identifier, $value);
    }

    public function setClob($identifier, \blaze\ds\type\Clob $value) {
        $this->stmt->setClob($identifier, $value);
    }

    public function setDate($identifier, \blaze\util\Date $value) {
        $this->stmt->setDate($identifier, $value);
    }

    public function setDecimal($identifier, \blaze\math\BigDecimal $value) {
        $this->stmt->setDecimal($identifier, $value);
    }

    public function setDouble($identifier, $value) {
        $this->stmt->setDouble($identifier, $value);
    }

    public function setEntity($identifier, \blaze\lang\Object $value) {
//        $meta = $this->EntityManager->getEntityManagerFactory()->getClassMeta($value);
//
//        if($meta === null)
//            throw new PersistenceException('Class of the given object is not registered in the EntityManager factory.');
//
//        $joinMembers = array();
//
//        foreach($meta->getMembers() as $member){
//            if($member instanceof \blaze\persistence\tool\metainfo\IdMetaInfo)
//                $joinMembers[] = $member;
//        }
//
//        foreach($joinMembers as $member){
//
//        }
    }

    public function setFloat($identifier, $value) {
        $this->stmt->setFloat($identifier, $value);
    }

    public function setInt($identifier, $value) {
        $this->stmt->setInt($identifier, $value);
    }

    public function setLong($identifier, $value) {
        $this->stmt->setLong($identifier, $value);
    }

    public function setNClob($identifier, \blaze\ds\type\NClob $value) {
        $this->stmt->setNClob($identifier, $value);
    }

    public function setNString($identifier, $value) {
        $this->stmt->setNString($identifier, $value);
    }

    public function setNull($identifier) {
        $this->stmt->setNull($identifier);
    }

    public function setString($identifier, $value) {
        $this->stmt->setString($identifier, $value);
    }

    public function setTime($identifier, \blaze\util\Date $value) {
        $this->stmt->setTime($identifier, $value);
    }

    public function setTimestamp($identifier, \blaze\util\Date $value) {
        $this->stmt->setTimestamp($identifier, $value);
    }

}

?>
