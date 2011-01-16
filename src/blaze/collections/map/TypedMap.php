<?php

namespace blaze\collections\map;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a map.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedMap extends AbstractMapDecorator implements \blaze\collections\Typed {

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
     * Creates a decorator over the given map with the given type checkers to check the type of keys and values.
     *
     * @param \blaze\collections\Map $map The decorated map
     * @param \blaze\collections\TypeChecker $typeCheckerKey The type checker for the key
     * @param \blaze\collections\TypeChecker $typeCheckerValue The type checker for the value
     */
    public function __construct(\blaze\collections\Map $map, \blaze\collections\TypeChecker $typeCheckerKey, \blaze\collections\TypeChecker $typeCheckerValue) {
        parent::__construct($map);
        $this->typeCheckerKey = $typeCheckerKey;
        $this->typeCheckerValue = $typeCheckerValue;
    }

    private function checkKey($key) {
        if (!$this->typeCheckerKey->isType($key))
            throw new \blaze\lang\IllegalArgumentException('This map may only contain keys of the given type ' . $this->typeCheckerKey->getType());
    }

    private function checkValue($value) {
        if (!$this->typeCheckerValue->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This map may only contain values of the given type ' . $this->typeCheckerValue->getType());
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

}

?>
