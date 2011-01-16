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
interface PersistentCollection {
    /**
     * Returns wether the collection is synchronized
     * with the database or not.
     *
     * @return boolean
     */
    public function isDirty();
    /**
     * Sets a flag which indicates wether the collection
     * is synchronized with the database or not.
     *
     * @param boolean $dirty
     */
    public function setDirty(\boolean $dirty);
    /**
     * Returns the object which is the owner of this collection.
     *
     * @return \blaze\lang\Object
     */
    public function getOwner();
    /**
     * Sets the owner object of this collection
     *
     * @param \blaze\lang\Object $owner
     */
    public function setOwner(\blaze\lang\Object $owner);
}

?>
