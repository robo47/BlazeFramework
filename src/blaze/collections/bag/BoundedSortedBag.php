<?php

namespace blaze\collections\bag;

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
final class BoundedSortedBag extends AbstractSortedBagDecorator implements \blaze\collections\Bounded {

    private $maxCount;

    public function __construct(SortedBag $bag, $maxCount) {
        parent::__construct($bag);
        $this->maxCount = $maxCount;
    }

    public function add($obj) {
        if (!$this->isFull())
            return $this->bag->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        if ($obj->count() + $this->count() <= $this->maxCount)
            return $this->bag->addAll($obj);
    }

    public function addCount($obj, $count) {
        if (!$this->contains($obj)) {
            if (!$this->isFull())
                return $this->bag->addCount($obj, $count);
            else
                return false;
        }else {
            return $this->bag->addCount($obj, $count);
        }
    }

    public function isFull() {
        return $this->bag->count() == $this->maxCount;
    }

    public function maxCount() {
        return $this->maxCount;
    }

}

?>
