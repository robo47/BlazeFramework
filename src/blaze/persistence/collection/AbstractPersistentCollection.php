<?php

namespace blaze\persistence\collection;

use blaze\lang\Object;

/**
 * Description of PersistentCollection
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
abstract class AbstractPersistentCollection extends Object implements PersistentCollection{

    /**
     * @var boolean
     */
    protected $dirty = true;
    /**
     * @var \blaze\lang\Object
     */
    protected $owner = null;

    /**
     *
     * @var \blaze\persistence\EntityManager
     */
    protected $entitiyManager;
    /**
     *
     * @var \blaze\persistence\meta\ClassDescriptor
     */
    protected $classDescriptor;
    
    public function __construct(\blaze\persistence\EntityManager $em, \blaze\persistence\meta\ClassDescriptor $class){
        $this->entitiyManager = $em;
        $this->classDescriptor = $class;
    }

    public function isDirty(){
        return $this->dirty;
    }

    public function setDirty(\boolean $dirty){
        $this->dirty = $dirty;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function setOwner(\blaze\lang\Object $owner) {
        $this->owner = $owner;
    }

}

?>
