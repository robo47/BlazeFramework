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
abstract class AbstractBagDecorator extends \blaze\lang\Object implements \blaze\collections\Bag {

    protected $bag;

    public function __construct(\blaze\collections\Bag $bag) {
        $this->bag = $bag;
    }

    public function add($obj) {
        return $this->bag->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        return $this->bag->addAll($obj);
    }

    public function addCount($obj, $count) {
        return $this->bag->addCount($obj, $count);
    }

    public function clear() {
        return $this->bag->clear();
    }

    public function contains($obj) {
        return $this->bag->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        return $this->bag->containsAll($c);
    }

    public function count() {
        return $this->bag->count();
    }

    public function getCount($obj) {
        return $this->bag->getCount($obj);
    }

    public function isEmpty() {
        return $this->bag->isEmpty();
    }

    public function remove($obj) {
        return $this->bag->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        return $this->bag->removeAll($obj);
    }

    public function removeCount($obj, $count) {
        return $this->bag->removeCount($obj, $count);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        return $this->bag->retainAll($obj);
    }

    public function toArray($type = null) {
        return $this->bag->toArray($type);
    }

    public function uniqueSet() {
        return $this->bag->uniqueSet();
    }

}

?>
