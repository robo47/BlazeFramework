<?php

namespace blaze\collections\map;

use blaze\lang\Object,
 blaze\lang\Integer,
 blaze\lang\String;

/**
 * A simple implementation of a map which uses the hashcodes of objects.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @author  Oliver Kotzina
 * @todo    Tuning and full documentation.
 */
class HashMap extends AbstractMap implements \blaze\lang\Cloneable, \blaze\io\Serializable {

    /**
     *
     * @var int
     */
    protected $size;
    /**
     *
     * @var array[blaze\collections\MapEntry]
     */
    protected $data;
    /**
     *
     * @var array[int]
     */
    protected $hashs;

    public function __construct(\blaze\collections\Map $map = null) {
        $this->clear();
        if ($map != null) {
            foreach ($map as $val) {
                $this->put($val->getKey(), $val->getValue());
            }
        }
    }

    public function clear() {
        $this->size = 0;
        $this->data = array();
        $this->hashs = array();
    }

    public function containsKey(\blaze\lang\Reflectable $key) {
        return array_key_exists($this->hash($key), $this->data);
    }

    public function containsValue(\blaze\lang\Reflectable $value) {
        foreach ($this->data as &$val) {
            if ($val->getValue() == $value) {
                return true;
            }
        }
        return false;
    }

    public function entrySet() {
        $ret = new \blaze\collections\set\HashSet();
        foreach ($this->data as $val) {
            $ret->add($val);
        }
        return $ret;
    }

    public function keySet() {
        $ret = new \blaze\collections\set\HashSet();
        foreach ($this->data as $val) {
            $ret->add($val->getKey());
        }
        return $ret;
    }

    public function valueSet() {
        $ret = new \blaze\collections\set\HashSet();
        foreach ($this->data as $val) {
            $ret->add($val->getValue());
        }
        return $ret;
    }

    public function get(\blaze\lang\Reflectable $key) {
        $hash = $this->hash($key);
        if (array_key_exists($hash, $this->data)) {
            return $this->data[$hash]->getValue();
        }
        return null;
    }

    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {
        $hash = $this->hash($key);

        if (array_key_exists($hash, $this->data)) {
            $old = $this->data[$hash];
            $this->data[$hash]->setValue($value);
            return $old->getValue();
        }
        $this->data[$hash] = new HashMapEntry($key, $value);
        $this->hashs[$this->size] = $hash;
        $this->size++;
        return null;
    }

    public function putAll(\blaze\collections\Map $m) {
        foreach ($m as $value) {
            $this->put($value->getKey(), $value->getValue());
        }
    }

    public function remove(\blaze\lang\Reflectable $key) {
        $hash = $this->hash($key);

        if ($this->containsKey($key)) {
            unset($this->data[$hash]);
            unset($this->hashs[$this->indexOf($hash)]);
            $this->hashs = \array_values($this->hashs);
            $this->size--;
            return true;
        } else {
            return false;
        }
    }

    public function values() {
        $list = new \blaze\collections\lists\ArrayList();
        foreach ($this as $val) {
            $list->add($val->getValue());
        }
        return $list;
    }

    public function isEmpty() {
        return $this->size == 0;
    }

    public function count() {
        return $this->size;
    }

    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator() {
        return new HashMapIterator($this->data, $this->hashs, $this);
    }

    public function containsAll(\blaze\collections\Map $c) {
        foreach ($c as $val) {
            if (!$this->containsKey($val->getKey())) {
                return false;
            }
        }
        return true;
    }

    public function removeAll(\blaze\collections\Map $obj) {
        $ret = false;
        foreach ($obj as $value) {
            if ($this->remove($value->getKey())) {
                $ret = true;
            }
        }
        return $ret;
    }

    public function retainAll(\blaze\collections\Map $obj) {
        foreach ($this as $val) {
            if (!$obj->containsKey($val->getKey())) {
                $this->remove($val->getKey());
            }
        }
    }

    private function hash($key) {
        return String::asNative($key->hashCode());
    }

    public function toString() {
        $str = new \blaze\lang\StringBuffer('HashMap:{');
        foreach ($this->data as $val) {
            $str->append(' [' . $val->getKey() . ',' . $val->getValue() . ']');
        }
        $str->append('}');
    }

    private function indexOf($hash) {
        $index = array_search($hash, $this->hashs);
        if (\is_int($index)) {
            return $index;
        } else {
            return -1;
        }
    }

}

/**
 * @access private
 */
class HashMapEntry extends Object implements \blaze\collections\MapEntry {

    private $key;
    private $value;

    public function __construct($key, $value) {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey() {
        return $this->key;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue(\blaze\lang\Reflectable $value) {
        $old = $this->value;
        $this->value = $value;
        return $old;
    }

    public function hashCode() {

        if ($this->key instanceof Object) {
            return String::asNative($this->key->hashCode());
        } else {
            return String::asNative(Integer::hexStringToInt(md5($this->key)));
        }
    }

}

/**
 * @access private
 */
class HashMapIterator implements \blaze\collections\MapIterator {

    /**
     *
     * @var array[blaze\collections\MapEntry]
     */
    private $data;
    private $hashs;
    private $index = 0;
    /**
     *
     * @var HashMap
     */
    private $map;

    public function __construct(&$data, &$hashs, &$map) {
        if (is_array($data)) {
            $this->data = $data;
            $this->hashs = $hashs;
            $this->map = $map;
        } else {
            throw new \blaze\lang\IllegalArgumentException('data must be a Array!');
        }
    }

    public function current() {
        return $this->data[$this->hashs[$this->index]]->getValue();
    }

    public function getKey() {
        return $this->data[$this->hashs[$this->index]]->getKey();
    }

    public function getValue() {
        return $this->data[$this->hashs[$this->index]]->getValue();
    }

    public function hasNext() {
        return $this->check($this->index + 1);
    }

    public function key() {
        $key = $this->getKey();
        if($key instanceof \blaze\lang\NativeWrapper)
            return $key->toNative();
        return $key;
    }

    /**
     *
     * @return \blaze\collections\MapEntry
     */
    public function next() {
        $this->index++;
        if ($this->check($this->index)) {
            return $this->data[$this->hashs[$this->index]];
        } else {
            return false;
        }
    }

    public function remove() {
        $this->map->remove($this->getKey());
    }

    public function rewind() {
        $this->index = 0;
    }

    public function setValue(\blaze\lang\Reflectable $value) {
        $old = $this->getValue();
        $this->data[$this->hashs[$this->index]]->setValue($value);
        return $old;
    }

    public function valid() {
        return $this->check($this->index);
    }

    private function check($index) {
        return array_key_exists($index, $this->hashs);
    }

}

?>