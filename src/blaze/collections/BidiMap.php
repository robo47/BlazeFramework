<?php
namespace blaze\collections;
use blaze\lang\Object;
/**
 * Keys and Values must be unique, looking up the key by a value
 * may not take longer than value by key. So there must be an inverted Map
 * which requires that values are unique.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface BidiMap extends Map{
    /**
     * @return blaze\collections\Set
     */
    public function valueSet();
    /**
     * @return mixed
     */
    public function getKey($value);
    /**
     * @return mixed the key or null if nothing was removed
     */
    public function removeValue($value);
}

?>
