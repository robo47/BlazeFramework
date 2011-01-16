<?php

namespace blaze\collections\bag;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a sorted bag.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedSortedBag extends AbstractSortedBagDecorator implements \blaze\collections\Typed {

    /**
     * The object to check value types.
     * @var \blaze\collections\TypeChecker
     */
    private $typeChecker;

    /**
     * Creates a decorator over the given sorted bag with the given typeChecker to check the type of values.
     *
     * @param \blaze\collections\bag\SortedBag $bag The decorated sorted bag
     * @param \blaze\collections\TypeChecker $typeChecker The type checker
     */
    public function __construct(\blaze\collections\bag\SortedBag $bag, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($bag);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('The sorted bag may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->bag->add($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->bag->addAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function addCount(\blaze\lang\Reflectable $obj, \int $count) {
        $this->check($obj);
        return $this->bag->addCount($obj, $count);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->bag->remove($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->bag->removeAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeCount(\blaze\lang\Reflectable $obj, \int $count) {
        $this->check($obj);
        return $this->bag->removeCount($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->bag->retainAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function contains(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->bag->contains($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($c as $o)
            $this->check($o);
        return $this->bag->containsAll($c);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function getCount(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->bag->getCount($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceiling(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->bag->ceiling($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floor(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->bag->floor($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function headBag(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->bag->headBag($toElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function headCollection(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->bag->headCollection($toElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higher(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->bag->higher($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lower(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->bag->lower($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function subBag(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->bag->subBag($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function subCollection(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->bag->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function tailBag(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->bag->tailBag($fromElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function tailCollection(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->bag->tailCollection($fromElement, $inclusive);
    }

}

?>
