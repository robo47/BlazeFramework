<?php

namespace blaze\collections\set;

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
abstract class AbstractSetDecorator extends \blaze\lang\Object implements \blaze\collections\Set {

    protected $set;

    public function __construct(\blaze\collections\Set $set) {
        $this->set = $set;
    }

    public function add($obj) {
        return $this->set->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        return $this->set->addAll($obj);
    }

    public function clear() {
        return $this->set->clear();
    }

    public function contains($obj) {
        return $this->set->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        return $this->set->containsAll($c);
    }

    public function count() {
        return $this->set->count();
    }

    public function isEmpty() {
        return $this->set->isEmpty();
    }

    public function remove($obj) {
        return $this->set->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        return $this->set->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        return $this->set->retainAll($obj);
    }

    public function toArray($type = null) {
        return $this->set->toArray($type);
    }

}

?>
