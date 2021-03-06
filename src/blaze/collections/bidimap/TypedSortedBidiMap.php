<?php

namespace blaze\collections\bidimap;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a sorted bidimap.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedSortedBidiMap extends AbstractSortedBidiMapDecorator implements \blaze\collections\Typed {

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
     * Creates a decorator over the given sorted bidimap with the given type checkers to check the type of keys and values.
     *
     * @param \blaze\collections\bidimap\SortedBidiMap $bidiMap The decorated sorted bidimap
     * @param \blaze\collections\TypeChecker $typeCheckerKey The type checker for the key
     * @param \blaze\collections\TypeChecker $typeCheckerValue The type checker for the value
     */
    public function __construct(\blaze\collections\bidimap\SortedBidiMap $bidiMap, \blaze\collections\TypeChecker $typeCheckerKey, \blaze\collections\TypeChecker $typeCheckerValue) {
        parent::__construct($bidiMap);
        $this->typeCheckerKey = $typeCheckerKey;
        $this->typeCheckerValue = $typeCheckerValue;
    }

    private function checkKey($key) {
        if (!$this->typeCheckerKey->isType($key))
            throw new \blaze\lang\IllegalArgumentException('This sorted bidi map may only contain keys of the given type ' . $this->typeCheckerKey->getType());
    }

    private function checkValue($value) {
        if (!$this->typeCheckerValue->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This sorted bidi map may only contain values of the given type ' . $this->typeCheckerValue->getType());
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function put(\blaze\lang\Reflectable $key, \blaze\lang\Reflectable $value) {
        $this->checkKey($key);
        $this->checkValue($value);
        return $this->bidiMap->put($key, $value);
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
        return $this->bidiMap->putAll($m);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsKey(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->bidiMap->containsKey($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function containsValue(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->bidiMap->containsValue($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function remove(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->bidiMap->remove($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function removeValue(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->bidiMap->removeValue($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function get(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->bidiMap->get($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function getKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->bidiMap->getKey($value);
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
        return $this->bidiMap->containsAll($obj);
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
        return $this->bidiMap->removeAll($obj);
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
        return $this->bidiMap->retainAll($obj);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceiling(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->bidiMap->ceiling($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceilingEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->bidiMap->ceilingEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function ceilingKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->bidiMap->ceilingKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floor(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->bidiMap->floor($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floorEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->bidiMap->floorEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function floorKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->bidiMap->floorKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function headMap(\blaze\lang\Reflectable $toElement, $inclusive = true) {
        $this->checkKey($toElement);
        return $this->bidiMap->headMap($toElement, $inclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higher(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->bidiMap->higher($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higherEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->bidiMap->higherEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function higherKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->bidiMap->higherKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lower(\blaze\lang\Reflectable $element) {
        $this->checkKey($element);
        return $this->bidiMap->lower($element);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lowerEntry(\blaze\lang\Reflectable $key) {
        $this->checkKey($key);
        return $this->bidiMap->lowerEntry($key);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function lowerKey(\blaze\lang\Reflectable $value) {
        $this->checkValue($value);
        return $this->bidiMap->lowerKey($value);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function subMap(\blaze\lang\Reflectable $fromElement, \blaze\lang\Reflectable $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->checkKey($fromElement);
        $this->checkKey($toElement);
        return $this->bidiMap->subMap($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    /**
     * {@inheritDoc}
     * Type checking is added.
     * @throws \blaze\lang\IllegalArgumentException When an element has an illegal type.
     */
    public function tailMap(\blaze\lang\Reflectable $fromElement, $inclusive = true) {
        $this->checkKey($fromElement);
        return $this->bidiMap->tailMap($fromElement, $inclusive);
    }

}

?>
