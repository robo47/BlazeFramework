<?php

namespace blaze\collections\collection;

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
final class TypedSortedCollection extends AbstractSortedCollectionDecorator implements \blaze\collections\Typed {

    private $typeChecker;

    public function __construct(\blaze\collections\Collection $collection, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($collection);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This sorted collection may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    public function add($obj) {
        $this->check($obj);
        return $this->collection->add($obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->addAll($obj);
    }

    public function contains($obj) {
        $this->check($obj);
        return $this->collection->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->containsAll($c);
    }

    public function remove($obj) {
        $this->check($obj);
        return $this->collection->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->collection->retainAll($obj);
    }

    public function ceiling($element) {
        $this->check($element);
        return $this->collection->ceiling($element);
    }

    public function floor($element) {
        $this->check($element);
        return $this->collection->floor($element);
    }

    public function headCollection($toElement, $inclusive = true) {
        $this->check($toElement);
        return $this->collection->headCollection($toElement, $inclusive);
    }

    public function higher($element) {
        $this->check($element);
        return $this->collection->higher($element);
    }

    public function lower($element) {
        $this->check($element);
        return $this->collection->lower($element);
    }

    public function subCollection($fromElement, $toElement, $fromInclusive = true, $toInclusive = true) {
        $this->check($fromElement);
        $this->check($toElement);
        return $this->collection->subCollection($fromElement, $toElement, $fromInclusive, $toInclusive);
    }

    public function tailCollection($fromElement, $inclusive = true) {
        $this->check($fromElement);
        return $this->collection->tailCollection($fromElement, $inclusive);
    }

}

?>
