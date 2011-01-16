<?php

namespace blaze\collections\bag;

/**
 * This is a basic implementation of a BagDecorator which can be used to
 * give a Bag a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractBagDecorator extends \blaze\collections\collection\AbstractCollectionDecorator implements \blaze\collections\Bag {

    /**
     * The decorated bag.
     * @var \blaze\collections\Bag
     */
    protected $bag;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\Bag $bag The decorated bag.
     */
    public function __construct(\blaze\collections\Bag $bag) {
        parent::__construct($bag);
        $this->bag = $bag;
    }

    public function addCount(\blaze\lang\Reflectable $obj, \int $count) {
        return $this->bag->addCount($obj, $count);
    }

    public function getCount(\blaze\lang\Reflectable $obj) {
        return $this->bag->getCount($obj);
    }

    public function removeCount(\blaze\lang\Reflectable $obj, \int $count) {
        return $this->bag->removeCount($obj, $count);
    }

    public function uniqueSet() {
        return $this->bag->uniqueSet();
    }

}

?>
