<?php

namespace blaze\collections\collection;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a sorted collection.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedSortedCollection extends AbstractSortedCollectionDecorator implements \blaze\collections\Typed {

    /**
     * The object to check value types.
     * @var \blaze\collections\TypeChecker
     */
    private $typeChecker;

    /**
     * Creates a decorator over the given sorted collection with the given typeChecker to check the type of values.
     *
     * @param \blaze\collections\collection\SortedCollection $collection The decorated sorted collection
     * @param \blaze\collections\TypeChecker $typeChecker The type checker
     */
    public function __construct(\blaze\collections\collection\SortedCollection $collection, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($collection);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This sorted collection may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function add(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->collection->add($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->addAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function contains(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->collection->contains($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->containsAll($c);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function remove(\blaze\lang\Reflectable $obj) {
        $this->check($obj);
        return $this->collection->remove($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->removeAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->retainAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceiling(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->collection->ceiling($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floor(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->collection->floor($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function headCollection(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->collection->headCollection($toElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higher(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->collection->higher($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lower(\blaze\lang\Reflectable $element) {
        $this->check($element);
        return $this->collection->lower($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function subCollection(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->collection->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function tailCollection(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->collection->tailCollection($fromElement, $inclusive);
    }

}

?>
