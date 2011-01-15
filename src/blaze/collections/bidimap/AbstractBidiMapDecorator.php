<?php

namespace blaze\collections\bidimap;

use blaze\lang\Object;

/**
 * This is a basic implementation of a BidiMapDecorator which can be used to
 * give a BidiMap a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractBidiMapDecorator extends \blaze\collections\map\AbstractMapDecorator implements \blaze\collections\BidiMap {

    /**
     * The decorated bidimap.
     * @var \blaze\collections\BidiMap
     */
    protected $bidiMap;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\BidiMap $bidiMap The decorated bidimap.
     */
    public function __construct(\blaze\collections\BidiMap $bidiMap) {
        parent::__construct($bidiMap);
        $this->bidiMap = $bidiMap;
    }

    public function getKey(\blaze\lang\Reflectable $value) {
        return $this->bidiMap->getKey($value);
    }

    public function removeValue(\blaze\lang\Reflectable $value) {
        return $this->bidiMap->removeValue($value);
    }

    public function valueSet() {
        return $this->bidiMap->valueSet();
    }

}

?>
