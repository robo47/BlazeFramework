<?php

namespace blaze\persistence\collection;

use blaze\lang\Object;

/**
 * Description of PersistentSet
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class PersistentSet extends AbstractPersistentCollection implements \blaze\collections\Set{
    
    public function __construct(\blaze\persistence\EntityManager $em, \blaze\persistence\meta\ClassDescriptor $class){
        parent::__construct($em, $class);
    }

    public function add(\blaze\lang\Reflectable $obj) {

    }

    public function addAll(\blaze\collections\Collection $obj) {

    }

    public function clear() {

    }

    public function isEmpty() {

    }

    public function getIterator() {

    }

    public function count() {

    }

    public function contains(\blaze\lang\Reflectable $obj) {

    }

    public function containsAll(\blaze\collections\Collection $c) {

    }

    public function remove(\blaze\lang\Reflectable $obj) {

    }

    public function removeAll(\blaze\collections\Collection $obj) {

    }

    public function retainAll(\blaze\collections\Collection $obj) {

    }

    public function toArray($type = null) {

    }
}

?>
