<?php
namespace blaze\collections;

/**
 * Description of Queue
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     http://download.oracle.com/javase/6/docs/api/java/util/Queue.html
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Queue extends Collection{
    /**
     * @return boolean
     */
     public function offer($element);
     /**
      * Retrieves, but does not remove, the head of this queue, or returns null if this queue is empty.
      */
     public function peek();
     /**
      * Retrieves and removes the head of this queue, or returns null if this queue is empty.
      */
     public function poll();
     /**
      * Retrieves, but does not remove, the head of this queue.
      */
     public function element();
     /**
      * Retrieves and removes the head of this queue.
      * The base remove($obj) calls this method too.
      */
     public function removeElement();

    }

?>
