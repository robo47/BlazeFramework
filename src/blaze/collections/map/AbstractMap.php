<?php
namespace blaze\collections\map;
use blaze\lang\Object;

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
abstract class AbstractMap extends Object implements \blaze\collections\Map{
    public function clear(){}
    public function containsKey($key){}
    public function containsValue($value){}
    public function entrySet(){}
    public function keySet(){}
    public function valueSet(){}
    public function get($key){}
    public function put($key, $value){}
    public function putAll(\blaze\collections\Map $m){}
    public function remove($key){}
    public function values(){}
    public function isEmpty(){}
    public function count(){}
    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator(){}

    public function containsAll(Map $c) {

    }

    public function removeAll(Map $obj) {

    }

    public function retainAll(Map $obj) {

    }
}

?>
