<?php

namespace blaze\collections\bidimap;

use blaze\lang\Object,
 \blaze\collections\map\HashMap;

/**
 * Description of Queue
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Queue.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class HashBidiMap extends AbstractBidiMap {
/**
 *
 * @var \blaze\collections\map\HashMap
 */
    private $firstMap;
    /**
 *
 * @var \blaze\collections\map\HashMap
 */
    private $secondMap;

    public function __construct(\blaze\collections\Map $map=null){
        if($map===null){
            $this->firstMap = new \blaze\collections\map\HashMap(null);
            $this->secondMap = new \blaze\collections\map\HashMap(null);
        }
        else{
            $this->firstMap = new HashMap($map);   
        }
    }
    public function clear() {
        
    }

    public function containsKey($key) {
        
    }

    public function containsValue($value) {
        
    }

    public function count() {
        
    }

    public function entrySet() {
        
    }

    public function get($key) {
        
    }

    public function getKey($value) {
        
    }

    public function isEmpty() {
        
    }

    public function keySet() {
        
    }

    public function put($key, $value) {
        
    }

    public function putAll(\blaze\collections\Map $m) {
        
    }

    public function remove($key) {
        
    }

    public function removeValue($value) {
        
    }

    public function valueSet() {
        
    }

    public function values() {
        
    }

}

?>
