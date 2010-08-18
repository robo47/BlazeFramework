<?php

namespace blaze\collections\set;

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
final class TypedSortedSet extends AbstractSortedSetDecorator implements \blaze\collections\Typed {

    private $typeChecker;

    public function __construct(\blaze\collections\Set $set, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($set);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This sorted set may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    public function add($obj) {
        $this->check($obj);
        return $this->set->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->addAll($obj);
    }

    public function contains($obj) {
        $this->check($obj);
        return $this->set->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->containsAll($c);
    }

    public function remove($obj) {
        $this->check($obj);
        return $this->set->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->set->retainAll($obj);
    }

    public function ceiling($element) {
        $this->check($element);
        return $this->set->ceiling($element);
    }

    public function floor($element) {
        $this->check($element);
        return $this->set->floor($element);
    }

    public function headCollection($toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->set->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        $this->check($element);
        return $this->set->higher($element);
    }

    public function lower($element) {
        $this->check($element);
        return $this->set->lower($element);
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->set->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->set->tailCollection($fromElement, $inclusive);
    }

    public function headSet($toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->set->headSet($toElement, $inclusive);
    }

    public function subSet($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->set->subSet($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailSet($fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->set->tailSet($fromElement, $inclusive);
    }

}

?>
