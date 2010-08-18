<?php

namespace blaze\collections\bidimap;

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
final class BoundedBidiMap extends AbstractBidiMapDecorator implements \blaze\collections\Bounded {

    private $maxCount;

    public function __construct(\blaze\collections\BidiMap $bidiMap, $maxCount) {
        parent::__construct($bidiMap);
        $this->maxCount = $maxCount;
    }

    public function isFull() {
        return $this->count() == $this->maxCount;
    }

    public function maxCount() {
        return $this->maxCount;
    }

    public function put($key, $value) {
        if (!$this->isFull())
            return $this->bidiMap->put($key, $value);
    }

    public function putAll(\blaze\collections\Map $m) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->bidiMap->putAll($m);
    }
    
}

?>
