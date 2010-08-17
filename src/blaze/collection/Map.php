<?php
namespace blaze\collection;
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
interface Map extends Countable{
    public function clear();
    public function containsKey($key);
    public function containsValue($value);
    public function entrySet();
    public function keySet();
    public function valueSet();
    public function get($key);
    public function put($key, $value);
    public function putAll(Map $m);
    public function remove($key);
    public function values();
}

?>
