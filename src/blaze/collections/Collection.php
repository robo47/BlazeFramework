<?php
namespace blaze\collections;

/**
 * The main interface of all generic data structures. A collection is a data
 * store for objects and provides standard operations to manipulate this store.
 * An implementation of Collection should provide a constructor which accepts
 * an optional parameter collection which can represent a given data store.
 * This data store shall then be transformed or their elements shall be inserted
 * into the structure of the given implementation.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 */
interface Collection extends Iterable, Countable{
    /**
     * Adds an object to the collection.
     * @return boolean Wether the action was successfull or not
     */
    public function add($obj);
    /**
     * Adds all objects of the parameter to this collection.
     * @return boolean Wether the action was successfull or not
     */
    public function addAll(Collection $obj);
    /**
     * Removes all elements from this collections
     */
    public function clear();
    /**
     * Checks if the object is within the collection.
     * @return boolean True if the element obj is in this collections
     */
    public function contains($obj);
    /**
     * Checks if every object of the parameter collection is in this collection.
     * @return boolean True if every element of c is in this collections
     */
    public function containsAll(Collection $c);
    /**
     * Removes the given object from the collection.
     * @return boolean Wether the action was successfull or not
     */
    public function remove($obj);
    /**
     * Removes every object of the parameter collection of this collection.
     * @return boolean Wether the action was successfull or not
     */
    public function removeAll(Collection $obj);
    /**
     * Retains only objects which are in the parameter collection and this collection.
     * @return boolean Wether the action was successfull or not
     */
    public function retainAll(Collection $obj);
    /**
     * Creates a new array which holds the objects of this collection
     * @return blaze\collections\ArrayI
     */
    public function toArray($type = null);
}

?>
