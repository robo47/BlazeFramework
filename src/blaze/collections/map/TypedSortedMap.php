<?php

namespace blaze\collections\map;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a sorted map.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedSortedMap extends AbstractSortedMapDecorator implements \blaze\collections\Typed {

    /**
     * The object to check key types.
     * @var \blaze\collections\TypeChecker
     */
    private $typeCheckerKey;
    /**
     * The object to check value types.
     * @var \blaze\collections\TypeChecker
     */
    private $typeCheckerValue;

    /**
     * Creates a decorator over the given sorted map with the given type checkers to check the type of keys and values.
     *
     * @param \blaze\collections\map\SortedMap $map The decorated sorted map
     * @param \blaze\collections\TypeChecker $typeCheckerKey The type checker for the key
     * @param \blaze\collections\TypeChecker $typeCheckerValue The type checker for the value
     */
    public function __construct(\blaze\collections\map\SortedMap $map, \blaze\collections\TypeChecker $typeCheckerKey, \blaze\collections\TypeChecker $typeCheckerValue) {
        parent::__construct($map);
        $this->typeCheckerKey = $typeCheckerKey;
        $this->typeCheckerValue = $typeCheckerValue;
    }

    private function checkKey($key) {
        if (!$this->typeCheckerKey->isType($key))
            throw new \blaze\lang\IllegalArgumentException('This sorted map may only contain keys of the given type ' . $this->typeCheckerKey->getType());
    }

    private function checkValue($value) {
        if (!$this->typeCheckerValue->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This sorted map may only contain values of the given type ' . $this->typeCheckerValue->getType());
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {
        $this->checkKey($key);
        $this->checkValue($value);
        return $this->map->put($key, $value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function putAll(\blaze\collections\Map $m) {
        foreach ($m as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->putAll($m);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsKey(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->map->containsKey($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsValue(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->map->containsValue($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function remove(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->map->remove($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function get(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->map->get($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->containsAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->removeAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function retainAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->retainAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceiling(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->map->ceiling($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceilingEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->map->ceilingEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceilingKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->map->ceilingKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floor(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->map->floor($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floorEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->map->floorEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floorKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->map->floorKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function headMap(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        $this->checkKey($toElement);
        return $this->map->headMap($toElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higher(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->map->higher($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higherEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->map->higherEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higherKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->map->higherKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lower(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->map->lower($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lowerEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->map->lowerEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lowerKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->map->lowerKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function subMap(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->checkKey($fromElement);
        $this->checkKey($toElement);
        return $this->map->subMap($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function tailMap(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        $this->checkKey($fromElement);
        return $this->map->tailMap($fromElement, $inclusive);
    }

}

?>
