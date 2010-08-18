<?php
namespace blaze\collections\map;
use blaze\lang\Object;

/**
 * Description of Arrays
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @property-read int $length
 * @author  Christian Beikov
 * @todo    Implementing and documenting.
 */
class HashMap extends AbstractMap implements \blaze\lang\Cloneable, \blaze\io\Serializable {
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

    public function containsAll(\blaze\collections\Map $c) {

    }

    public function removeAll(\blaze\collections\Map $obj) {

    }

    public function retainAll(\blaze\collections\Map $obj) {

    }
}
?>