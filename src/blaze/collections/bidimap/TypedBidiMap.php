<?php

namespace blaze\collections\bidimap;

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
final class TypedBidiMap extends AbstractBidiMapDecorator implements \blaze\collections\Typed {

    private $typeCheckerKey;
    private $typeCheckerValue;

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

    public function put($key, $value) {
        $this->checkKey($key);
        $this->checkValue($value);
        return $this->bidiMap->put($key, $value);
    }

    public function putAll(\blaze\collections\Map $m) {
        foreach ($m as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->bidiMap->putAll($m);
    }

    public function containsKey($key) {
        $this->checkKey($key);
        return $this->bidiMap->containsKey($key);
    }

    public function containsValue($value) {
        $this->checkValue($value);
        return $this->bidiMap->containsValue($value);
    }

    public function remove($key) {
        $this->checkKey($key);
        return $this->bidiMap->remove($key);
    }

    public function removeValue($value) {
        $this->checkValue($value);
        return $this->bidiMap->removeValue($value);
    }

    public function get($key) {
        $this->checkKey($key);
        return $this->bidiMap->get($key);
    }

    public function getKey($value) {
        $this->checkValue($value);
        return $this->bidiMap->getKey($value);
    }

    public function containsAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->bidiMap->containsAll($obj);
    }

    public function removeAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->bidiMap->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->bidiMap->retainAll($obj);
    }

}

?>
