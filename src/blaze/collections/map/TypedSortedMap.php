<?php

namespace blaze\collections\map;

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
final class TypedSortedMap extends AbstractSortedMapDecorator implements \blaze\collections\Typed {

    private $typeCheckerKey;
    private $typeCheckerValue;

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

    public function put($key, $value) {
        $this->checkKey($key);
        $this->checkValue($value);
        return $this->map->put($key, $value);
    }

    public function putAll(\blaze\collections\Map $m) {
        foreach ($m as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->putAll($m);
    }

    public function containsKey($key) {
        $this->checkKey($key);
        return $this->map->containsKey($key);
    }

    public function containsValue($value) {
        $this->checkValue($value);
        return $this->map->containsValue($value);
    }

    public function remove($key) {
        $this->checkKey($key);
        return $this->map->remove($key);
    }

    public function get($key) {
        $this->checkKey($key);
        return $this->map->get($key);
    }

    public function containsAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->containsAll($obj);
    }

    public function removeAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Map $obj) {
        foreach ($obj as $o) {
            $this->checkKey($o->getKey());
            $this->checkValue($o->getValue());
        }
        return $this->map->retainAll($obj);
    }

    public function ceiling($element) {
        $this->checkKey($element);
        return $this->map->ceiling($element);
    }

    public function ceilingEntry($key) {
        $this->checkKey($key);
        return $this->map->ceilingEntry($key);
    }

    public function ceilingKey($value) {
        $this->checkValue($value);
        return $this->map->ceilingKey($value);
    }

    public function floor($element) {
        $this->checkKey($element);
        return $this->map->floor($element);
    }

    public function floorEntry($key) {
        $this->checkKey($key);
        return $this->map->floorEntry($key);
    }

    public function floorKey($value) {
        $this->checkValue($value);
        return $this->map->floorKey($value);
    }

    public function headMap($toElement, $inclusive = true) {
        $this->checkKey($toElement);
        return $this->map->headMap($toElement, $inclusive);
    }

    public function higher($element) {
        $this->checkKey($element);
        return $this->map->higher($element);
    }

    public function higherEntry($key) {
        $this->checkKey($key);
        return $this->map->higherEntry($key);
    }

    public function higherKey($value) {
        $this->checkValue($value);
        return $this->map->higherKey($value);
    }

    public function lower($element) {
        $this->checkKey($element);
        return $this->map->lower($element);
    }

    public function lowerEntry($key) {
        $this->checkKey($key);
        return $this->map->lowerEntry($key);
    }

    public function lowerKey($value) {
        $this->checkValue($value);
        return $this->map->lowerKey($value);
    }

    public function subMap($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->checkKey($fromElement);
        $this->checkKey($toElement);
        return $this->map->subMap($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailMap($fromElement, $inclusive = true) {
        $this->checkKey($fromElement);
        return $this->map->tailMap($fromElement, $inclusive);
    }

}

?>
