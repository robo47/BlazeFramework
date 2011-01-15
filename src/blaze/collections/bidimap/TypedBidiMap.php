<?php

namespace blaze\collections\bidimap;

/**
 * A simple decorator which uses the TypeChecker to strictly check the types of a bidimap.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class TypedBidiMap extends AbstractBidiMapDecorator implements \blaze\collections\Typed {

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
     * Creates a decorator over the given bidimap with the given type checkers to check the type of keys and values.
     *
     * @param \blaze\collections\BidiMap $bidiMap The decorated bidimap
     * @param \blaze\collections\TypeChecker $typeCheckerKey The type checker for the key
     * @param \blaze\collections\TypeChecker $typeCheckerValue The type checker for the value
     */
    public function __construct(\blaze\collections\BidiMap $bidiMap, \blaze\collections\TypeChecker $typeCheckerKey, \blaze\collections\TypeChecker $typeCheckerValue) {
        parent::__construct($bidiMap);
        $this->typeCheckerKey = $typeCheckerKey;
        $this->typeCheckerValue = $typeCheckerValue;
    }

    private function checkKey($key) {
        if (!$this->typeCheckerKey->isType($key))
            throw new \blaze\lang\IllegalArgumentException('This bidi map may only contain keys of the given type ' . $this->typeCheckerKey->getType());
    }

    private function checkValue($value) {
        if (!$this->typeCheckerValue->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This bidi map may only contain values of the given type ' . $this->typeCheckerValue->getType());
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

}

?>
