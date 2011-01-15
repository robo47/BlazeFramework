<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * An implementation of a map which manages only entries with the key type
 * string and the value type string.
 *
 * @author  Christian Beikov, Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Clean up the implementation, no need to extend from HashMap because of associative arrays in PHP. Documentation!
 */
class Properties extends AbstractMap {

    /**
     *
     * @var array
     */
    private $properties = array();

    public function __construct() {

    }

    public function setProperty(\blaze\lang\String $key, \blaze\lang\String $value) {
        if (array_key_exists($key->toNative(), $this->properties)) {
            return false;
        } else {
            $this->properties[$key->toNative()] = $value;
        }
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getProperty(\blaze\lang\String $key, \blaze\lang\String $default = null) {
        if (!array_key_exists($key->toNative(), $this->properties))
            return $default;
        return $this->properties[$key->toNative()];
    }

    /**
     * Create string representation that can be written to file and would be loadable using load() method.
     * 
     * Essentially this function creates a string representation of properties that is ready to
     * write back out to a properties file.  This is used by store() method.
     *
     * @return string
     */
    public function toString() {
        $buf = '';
        foreach ($this->properties as $key => $value) {
            $buf .= $key . '=' . $value . PHP_EOL;
        }
        return \blaze\lang\String::asWrapper($buf);
    }

    /**
     * Returns copy of internal properties hash.
     * Mostly for performance reasons, property hashes are often
     * preferable to passing around objects.
     *
     * @return array
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * Set the value for a property.
     * This function exists to provide hashtable-lie
     * interface for properties.
     *
     * @param string $key
     * @param mixed $value
     */
    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {
        return $this->setProperty($key, $value);
    }

    /**
     * Appends a value to a property if it already exists with a delimiter
     *
     * If the property does not, it just adds it.
     * 
     * @param string $key
     * @param mixed $value
     * @param string $delimiter
     */
    public function append(\blaze\lang\String $key, \blaze\lang\String $value, \blaze\lang\String $delimiter = null) {
        if($delimiter === null)
            $delimiter = new \blaze\lang\String(',');
        $newValue = $value;
        if (isset($this->properties[$key]) && !empty($this->properties[$key])) {
            $newValue = $this->properties[$key] . $delimiter . $value;
        }
        $this->properties[$key->toNative()] = \blaze\lang\String::asWrapper($newValue);
    }

    /**
     * Whether loaded properties array contains specified property name.
     * @return boolean
     */
    public function containsKey(\blaze\lang\Reflectable $key) {
        return isset($this->properties[$key->toString()->toNative()]);
    }

    /**
     * Returns the property names.
     * @return \blaze\collections\ArrayI[\blaze\lang\String]
     */
    public function propertyNames() {
        $a = new \blaze\collections\arrays\ArrayObject(count($this->properties));
        $keys = array_keys($this->properties);

        for($i = 0; $i < count($keys); $i++)
            $a[] = new \blaze\lang\String($keys);
    }

    /**
     * Whether properties list is empty.
     * @return boolean
     */
    public function isEmpty() {
        return empty($this->properties);
    }

    public function clear() {
        $this->size = 0;
        $this->properties = array();
    }

    public function containsValue(\blaze\lang\Reflectable $value) {
        foreach ($this->properties as &$val) {
            if ($val == $value) {
                return true;
            }
        }
        return false;
    }

    public function entrySet() {

    }

    public function keySet() {

    }

    public function valueSet() {

    }

    public function get(\blaze\lang\Reflectable $key) {
        if (array_key_exists($key, $this->properties)) {
            return $this->data[$key]->getValue();
        }
        return null;
    }

    public function putAll(\blaze\collections\Map $m) {
        foreach ($m as $value) {
            $this->put($value->getKey(), $value->getValue());
        }
    }

    public function remove(\blaze\lang\Reflectable $key) {


        if ($this->containsKey($key)) {
            unset($this->data[$key]);
            return true;
        } else {
            return false;
        }
    }

    public function removeAll(\blaze\collections\Map $obj) {

    }

    public function  retainAll(\blaze\collections\Map $obj) {
        
    }

    public function values() {

    }

    public function count() {
        return $this->size;
    }

    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator() {
        return new PropertiesIterator($this->properties);
    }

    /**
     *
     * @param \blaze\collections\Map $c
     * @return <type>
     * @todo Implement
     */
    public function containsAll(\blaze\collections\Map $c) {
        foreach ($c as $val) {
            if (!$this->containsKey($val->getKey())) {
                return false;
            }
        }
        return true;
    }

}

class PropertiesIterator implements \blaze\collections\MapIterator {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function current() {
        return current($this->data);
    }

    public function getKey() {
        return $this->key();
    }

    public function getValue() {
        return current($this->data);
    }

    public function hasNext() {
        if (next($this->data)) {
            prev($this->data);
            return true;
        } else {
            return false;
        }
    }

    public function key() {
        return key($this->data);
    }

    public function next() {
        return next($this->data);
    }

    public function remove() {
        unset($this->data[$this->key()]);
    }

    public function rewind() {
        reset($this->data);
    }

    public function setValue(\blaze\lang\Reflectable $value) {
        $old = current($this->data);
        $this->data[key($this->data)] = $value;
        return $old;
    }

    public function valid() {
        return (current($this->data) !== false);
    }

}

?>
