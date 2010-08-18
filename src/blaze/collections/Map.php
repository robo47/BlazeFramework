<?php
namespace blaze\collections;
use blaze\lang\Object;
/**
 * Description of List
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Map extends Countable, Iterable{
    public function clear();
    public function containsKey($key);
    public function containsValue($value);
    public function entrySet();
    public function keySet();
    /**
     * Return the value to the key
     * @return mixed
     */
    public function get($key);
    /**
     * @return mixed the value
     */
    public function put($key, $value);
    /**
     * Merge maps
     */
    public function putAll(Map $m);
    
    public function containsAll(Map $c);
    public function removeAll(Map $obj);
    public function retainAll(Map $obj);
    /**
     * 
     * @return mixed the value or null if nothing was removed
     */
    public function remove($key);
    /**
     * @return blaze\collections\Collection
     */
    public function values();

}

?>
