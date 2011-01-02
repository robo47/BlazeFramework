<?php

namespace blaze\collections\map;

/**
 * A map decorator which specifies bounds for a map
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class BoundedMap extends AbstractMapDecorator implements \blaze\collections\Bounded {

    /**
     * The maximal size of the map
     * @var int
     */
    private $maxCount;

    /**
     * Creates a new decorator for a map which is bounded.
     *
     * @param \blaze\collections\Map $map The decorated map
     * @param int $maxCount The maximal size
     */
    public function __construct(\blaze\collections\Map $map, $maxCount) {
        parent::__construct($map);
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
     * When the map is full nothing is added and false is returned.
     */
    public function put($key, $value) {
        if (!$this->isFull())
            return $this->map->put($key, $value);
    }

    /**
     * {@inheritDoc}
     * When the map has not enough space for all entries nothing is added and false is returned.
     */
    public function putAll(\blaze\collections\Map $m) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->map->putAll($m);
    }

}

?>
