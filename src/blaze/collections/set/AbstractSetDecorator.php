<?php

namespace blaze\collections\set;

/**
 * This is a basic implementation of a SetDecorator which can be used to
 * give a Set a different behaviour via the same interface by decorating it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractSetDecorator extends \blaze\collections\collection\AbstractCollectionDecorator implements \blaze\collections\Set {

    /**
     * The decorated set.
     * @var \blaze\collections\Set
     */
    protected $set;

    /**
     * Implementations must call this constructor for initialization.
     *
     * @param \blaze\collections\Set $set The decorated set.
     */
    public function __construct(\blaze\collections\Set $set) {
        parent::__construct($set);
        $this->set = $set;
    }

}

?>
