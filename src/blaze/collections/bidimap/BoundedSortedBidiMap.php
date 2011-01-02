<?php

namespace blaze\collections\bidimap;

/**
 * A sorted bidimap decorator which specifies bounds for a sorted bidimap.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedSortedBidiMap extends AbstractSortedBidiMapDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the bag
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a sorted bag which is bounded.
     *
     * @param \blaze\collections\bidimap\SortedBidiMap $bidiMap The decorated bidimap
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\bidimap\SortedBidiMap $bidiMap, $maxCount) {
        parent::__construct($bidiMap);
        $this->maxCount = $maxCount;
    }

    public function isFull() {
        return $this->count() == $this->maxCount;
    }

    public function maxCount() {
        return $this->maxCount;
    }

    /**
     * {@inheritDoc}
     * When the sorted bidimap is full nothing is added and false is returned.
     */
    public function put($key, $value) {
        if (!$this->isFull())
            return $this->bidiMap->put($key, $value);
        else
            return false;
    }

    /**
     * {@inheritDoc}
     * When the sorted bidimap has not enough space for all entries nothing is added and false is returned.
     */
    public function putAll(\blaze\collections\Map $m) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->bidiMap->putAll($m);
        else
            return false;
    }

}

?>
