<?php

namespace blaze\collections\set;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a sorted set.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedSortedSet extends AbstractSortedSetDecorator implements \blaze\collections\Typed {

    /**
     * The object to check value types.
     * @var \blaze\collections\TypeChecker
     */
    private $typeChecker;

    /**
     * Creates a decorator over the given sorted set with the given typeChecker to check the type of values.
     *
     * @param \blaze\collections\Set $set The decorated sorted set
     * @param \blaze\collections\TypeChecker $typeChecker The type checker
     */
    public function __construct(\blaze\collections\Set $set, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($set);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This sorted set may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->set->add($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->addAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function contains(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->set->contains($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->containsAll($c);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->set->remove($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->removeAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->retainAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceiling(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->set->ceiling($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floor(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->set->floor($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function headCollection(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->set->headCollection($toElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higher(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->set->higher($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lower(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->set->lower($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function subCollection(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->set->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function tailCollection(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->set->tailCollection($fromElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function headSet(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->set->headSet($toElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function subSet(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->set->subSet($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function tailSet(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->set->tailSet($fromElement, $inclusive);
    }

}

?>
