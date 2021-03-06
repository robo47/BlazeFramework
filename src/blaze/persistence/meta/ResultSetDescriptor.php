<?php

namespace blaze\persistence\meta;

use blaze\lang\Object;

/**
 * The ResultSetDescriptor holds column alias to property mappings which are
 * used by hydrators to push the values to the result objects. It also holds
 * the result class and can create an instance of it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
class ResultSetDescriptor extends Object {

    private $columnAliasToPropertyPathMapping;
    private $collectionProxies;
    private $resultClass;
    private $isArray;

    /**
     *
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $resultClass
     */
    public function __construct($resultClass, $isArray = false) {
        $this->columnAliasToPropertyPathMapping = array();
        $this->collectionProxies = array();

        if ($resultClass instanceof \blaze\lang\ClassWrapper)
            $this->resultClass = $resultClass;
        else
            $this->resultClass = \blaze\lang\ClassWrapper::forName(\blaze\lang\String::asNative($resultClass));
        $this->isArray = $isArray;
    }

    public function addFieldMapping(SingleFieldDescriptor $fieldDescriptor, $columnAlias = null) {
        if ($columnAlias === null)
            $columnAlias = $fieldDescriptor->getColumnDescriptor()->getName();

        if ($columnAlias === null)
            throw new \blaze\lang\Exception('No column name available');

        $columnAlias = \blaze\lang\String::asNative($columnAlias);
        $propPath = new PropertyPath();
        $propPath->addPathStep($fieldDescriptor->getType(), $fieldDescriptor->getName());
        $this->columnAliasToPropertyPathMapping[$columnAlias] = $propPath;
    }

    public function addCustomMapping($columnAlias, PropertyPath $propPath, $index = null) {

    }

    public function getFieldMappings() {
        return $this->columnAliasToPropertyPathMapping;
    }

    public function addCollectionMapping(CollectionFieldDescriptor $collectionDesc) {
        if($collectionDesc->getFieldDescriptor()->getType()->compareTo('blaze\\collections\\Set') == 0){
            /** @todo Set property to initialize PersistentSet for this field within the hydrator */
        }
    }

    public function getResultClassInstance() {
        return $this->resultClass->newInstance();
    }

}

?>
