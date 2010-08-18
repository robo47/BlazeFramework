<?php

namespace blaze\collections\queue;

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
abstract class AbstractQueueDecorator implements \blaze\collections\Queue {

    protected $queue;

    public function __construct(\blaze\collections\Queue $queue) {
        $this->queue = $queue;
    }

    public function add($obj) {
        return $this->queue->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        return $this->queue->addAll($obj);
    }

    public function clear() {
        return $this->queue->clear();
    }

    public function contains($obj) {
        return $this->queue->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        return $this->queue->containsAll($c);
    }

    public function count() {
        return $this->queue->count();
    }

    public function element() {
        return $this->queue->element();
    }

    public function isEmpty() {
        return $this->queue->isEmpty();
    }

    public function offer($element) {
        return $this->queue->offer($element);
    }

    public function peek() {
        return $this->queue->peek();
    }

    public function poll() {
        return $this->queue->poll();
    }

    public function remove($obj) {
        return $this->queue->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        return $this->queue->removeAll($obj);
    }

    public function removeElement() {
        return $this->queue->removeElement();
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        return $this->queue->retainAll($obj);
    }

    public function toArray($type = null) {
        return $this->queue->toArray($type);
    }

}

?>
