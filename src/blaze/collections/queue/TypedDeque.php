<?php

namespace blaze\collections\queue;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a deque.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedDeque extends AbstractDequeDecorator implements \blaze\collections\Typed {

    /**
     * The object to check value types.
     * @var \blaze\collections\TypeChecker
     */
    private $typeChecker;

    /**
     * Creates a decorator over the given deque with the given typeChecker to check the type of values.
     *
     * @param \blaze\collections\queue\Deque $deque The decorated deque
     * @param \blaze\collections\TypeChecker $typeChecker The type checker
     */
    public function __construct(\blaze\collections\queue\Deque $deque, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($deque);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This queue may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->queue->add($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->addAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function contains(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->queue->contains($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->containsAll($c);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->queue->remove($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->removeAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->queue->retainAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function offer(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->offer($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function addFirst(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->addFirst($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function addLast(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->addLast($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function offerFirst(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->offerFirst($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function offerLast(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->offerLast($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function push(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->push($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeFirstOccurrence(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->removeFirstOccurrence($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeLastOccurrence(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->queue->removeLastOccurrence($element);
    }

}

?>
