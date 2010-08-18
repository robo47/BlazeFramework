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
final class TypedQueue extends AbstractQueueDecorator implements \blaze\queues\Typed {

    private $typeChecker;

    public function __construct(\blaze\queues\Queue $queue, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($queue);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This queue may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    public function add($obj) {
        $this->check($obj);
        return $this->queue->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->addAll($obj);
    }

    public function contains($obj) {
        $this->check($obj);
        return $this->queue->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->containsAll($c);
    }

    public function remove($obj) {
        $this->check($obj);
        return $this->queue->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->retainAll($obj);
    }

    public function offer($element) {
        $this->check($element);
        return $this->queue->offer($element);
    }
    
}

?>
