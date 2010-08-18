<?php

namespace blaze\collections\bag;

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
final class TypedSortedBag extends AbstractSortedBagDecorator implements \blaze\collections\Typed {

    private $typeChecker;

    public function __construct(\blaze\collections\bag\SortedBag $bag, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($bag);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('The sorted bag may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    public function add($obj) {
        $this->check($obj);
        return $this->bag->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->bag->addAll($obj);
    }

    public function addCount($obj, $count) {
        $this->check($obj);
        return $this->bag->addCount($obj, $count);
    }

    public function remove($obj) {
        $this->check($obj);
        return $this->bag->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->bag->removeAll($obj);
    }

    public function removeCount($obj, $count) {
        $this->check($obj);
        return $this->bag->removeCount($obj);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->bag->retainAll($obj);
    }

    public function contains($obj) {
        $this->check($obj);
        return $this->bag->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($c as $o)
            $this->check($o);
        return $this->bag->containsAll($c);
    }

    public function getCount($obj) {
        $this->check($obj);
        return $this->bag->getCount($obj);
    }

    public function ceiling($element) {
        $this->check($element);
        return $this->bag->ceiling($element);
    }

    public function floor($element) {
        $this->check($element);
        return $this->bag->floor($element);
    }

    public function headBag($toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->bag->headBag($toElement, $inclusive);
    }

    public function headCollection($toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->bag->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        $this->check($element);
        return $this->bag->higher($element);
    }

    public function lower($element) {
        $this->check($element);
        return $this->bag->lower($element);
    }

    public function subBag($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->bag->subBag($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->bag->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailBag($fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->bag->tailBag($fromElement, $inclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->bag->tailCollection($fromElement, $inclusive);
    }

}

?>
