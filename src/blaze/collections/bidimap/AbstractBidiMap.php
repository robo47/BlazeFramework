<?php
namespace blaze\collections\bidimap;

/**
 * Some basic implementations of a BidiMap. By extending from this class, it is guaranteed
 * that implementations will work even if the interfaces get changed, because
 * empty methods will be added here.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractBidiMap extends \blaze\collections\map\AbstractMap implements \blaze\collections\BidiMap {

    public function values() {
        return $this->valueSet();
    }

}

?>
