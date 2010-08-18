<?php

namespace blaze\collections\lists;

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
final class TypedList extends AbstractListDecorator implements \blaze\collections\Typed {

    private $typeChecker;

    public function __construct(\blaze\collections\ListI $list, \blaze\collections\TypeChecker $typeChecker) {
        parent::__construct($list);
        $this->typeChecker = $typeChecker;
    }

    private function check($value) {
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\IllegalArgumentException('This list may only contain objects of the given type ' . $this->typeChecker->getType());
    }

    public function add($obj) {
        $this->check($obj);
        return $this->list->add($obj);
    }

    public function addAt($index, $obj) {
        $this->check($obj);
        return $this->list->addAt($index, $obj);
    }

    public function addAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->list->addAll($obj);
    }

    public function contains($obj) {
        $this->check($obj);
        return $this->list->contains($obj);
    }

    public function containsAll(\blaze\collections\Collection $c) {
        foreach ($c as $o)
            $this->check($o);
        return $this->list->containsAll($c);
    }

    public function indexOf($obj) {
        $this->check($obj);
        return $this->list->indexOf($obj);
    }

    public function lastIndexOf($obj) {
        $this->check($obj);
        return $this->list->lastIndexOf($obj);
    }

    public function remove($obj) {
        $this->check($obj);
        return $this->list->remove($obj);
    }

    public function removeAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->list->removeAll($obj);
    }

    public function retainAll(\blaze\collections\Collection $obj) {
        foreach ($obj as $o)
            $this->check($o);
        return $this->list->retainAll($obj);
    }

    public function set($index, $obj) {
        $this->check($obj);
        return $this->list->set($index, $obj);
    }

    public function subList($fromIndex, $toIndex, $fromInclusive = true, $toInclusive = false) {
        return $this->list->subList($fromIndex, $toIndex, $fromInclusive, $toInclusive);
    }

}

?>
