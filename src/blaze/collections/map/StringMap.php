<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * A Map which allows only Strings as keys. In addition to the normal methods
 * of a map, the StringMap offers methods to search in the map by prefix, suffix etc.
 * It uses a ternary search tree for the fast look up.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Overthink the design and where to put the TST implementation. Implementation and documentation.
 */
class StringMap extends \blaze\collections\map\AbstractMap {

    public function __construct() {

    }

    public function clear() {

    }

    public function containsKey(\blaze\lang\Reflectable $key) {

    }

    public function containsValue(\blaze\lang\Reflectable $value) {

    }

    public function entrySet() {

    }

    public function keySet() {

    }

    public function get(\blaze\lang\Reflectable $key) {

    }

    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {

    }

    public function putAll(\blaze\collections\Map $m) {

    }

    public function remove(\blaze\lang\Reflectable $key) {

    }

    public function values() {

    }

    public function isEmpty() {

    }

    public function count() {

    }

    public function getIterator() {

    }

    public function containsAll(\blaze\collections\Map $c) {

    }

    public function removeAll(\blaze\collections\Map $obj) {

    }

    public function retainAll(\blaze\collections\Map $obj) {

    }

    /**
     * Returns wether entries with the given keyPrefix exist or not.
     * @param string|\blaze\lang\String $keyPrefix
     * @return boolean
     */
    public function containsByPrefix($keyPrefix);

    /**
     * Returns wether entries with the given keySuffix exist or not.
     * @param string|\blaze\lang\String $keySuffix
     * @return boolean
     */
    public function containsBySuffix($keySuffix);

    /**
     * Returns wether entries which match the given regex exist or not.
     * @param string|\blaze\lang\String $regex
     * @return boolean
     */
    public function containsByRegex($regex);

    /**
     * Returns a list of values which keys have the given keyPrefix.
     * @param string|\blaze\lang\String $keyPrefix
     * @return \blaze\collections\ListI[mixed]
     */
    public function getByPrefix($keyPrefix);

    /**
     * Returns a list of values which keys have the given keySuffix.
     * @param string|\blaze\lang\String $keySuffix
     * @return \blaze\collections\ListI[mixed]
     */
    public function getBySuffix($keySuffix);

    /**
     * Returns a list of values which keys match the given regex.
     * @param string|\blaze\lang\String $regex
     * @return \blaze\collections\ListI[mixed]
     */
    public function getByRegex($regex);

    /**
     * Returns a list of entries which keys have the given keyPrefix.
     * @param string|\blaze\lang\String $keyPrefix
     * @return \blaze\collections\ListI[\blaze\collections\MapEntry]
     */
    public function getEntrySetByPrefix($keyPrefix);

    /**
     * Returns a list of entries which keys have the given keySuffix.
     * @param string|\blaze\lang\String $keySuffix
     * @return \blaze\collections\ListI[\blaze\collections\MapEntry]
     */
    public function getEntrySetBySuffix($keySuffix);

    /**
     * Returns a list of entries which keys match the given regex.
     * @param string|\blaze\lang\String $regex
     * @return \blaze\collections\ListI[\blaze\collections\MapEntry]
     */
    public function getEntrySetByRegex($regex);

    /**
     * Returns a set of keys which keys have the given keyPrefix.
     * @param string|\blaze\lang\String $keyPrefix
     * @return \blaze\collections\Set[\blaze\lang\String]
     */
    public function getKeySetByPrefix($keyPrefix);

    /**
     * Returns a set of keys which keys have the given keySuffix.
     * @param string|\blaze\lang\String $keySuffix
     * @return \blaze\collections\Set[\blaze\lang\String]
     */
    public function getKeySetBySuffix($keySuffix);

    /**
     * Returns a set of keys which keys match the given regex.
     * @param string|\blaze\lang\String $regex
     * @return \blaze\collections\Set[\blaze\lang\String]
     */
    public function getKeySetByRegex($regex);

    /**
     * Returns a collection of values which keys have the given keyPrefix.
     * @param string|\blaze\lang\String $keyPrefix
     * @return \blaze\collections\Collection[mixed]
     */
    public function getValuesByPrefix($keyPrefix);

    /**
     * Returns a collection of values which keys have the given keySuffix.
     * @param string|\blaze\lang\String $keySuffix
     * @return \blaze\collections\Collection[mixed]
     */
    public function getValuesBySuffix($keySuffix);

    /**
     * Returns a collection of values which keys match the given regex.
     * @param string|\blaze\lang\String $regex
     * @return \blaze\collections\Collection[mixed]
     */
    public function getValuesByRegex($regex);

    /**
     * Removes entries which keys have the given keyPrefix.
     * @param string|\blaze\lang\String $keyPrefix
     * @return boolean true on success, otherwise false.
     */
    public function removeByPrefix($keyPrefix);

    /**
     * Removes entries which keys have the given keySuffix.
     * @param string|\blaze\lang\String $keySuffix
     * @return boolean true on success, otherwise false.
     */
    public function removeBySuffix($keySuffix);

    /**
     * Removes entries which keys match the given regex.
     * @param string|\blaze\lang\String $regex
     * @return boolean true on success, otherwise false.
     */
    public function removeByRegex($regex);
}

?>
