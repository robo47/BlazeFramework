<?php
namespace blaze\collections;

/**
 * A Queue offers some methods which are similar to the ones in Collection but
 * do not throw exception
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 */
interface Queue extends Collection{
    /**
     * Adds the element to the queue.
     * @return boolean true if the element was added to this queue, else false
     */
     public function offer($element);
     /**
      * Retrieves, but does not remove, the head of this queue, or returns null if this queue is empty.
      * @return mixed
      */
     public function peek();
     /**
      * Retrieves and removes the head of this queue, or returns null if this queue is empty.
      * @return mixed
      */
     public function poll();
     /**
      * Retrieves, but does not remove, the head of this queue.
      * @return mixed
      */
     public function element();
     /**
      * Retrieves and removes the head of this queue.
      * The base remove($obj) calls this method too.
      * @return boolean Wether the action was successfull or not
      */
     public function removeElement();

    }

?>
