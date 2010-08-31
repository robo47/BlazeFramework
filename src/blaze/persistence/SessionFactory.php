<?php
namespace blaze\persistence;

/**
 * Description of SessionFactory
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface SessionFactory {
    /**
     * Returns a new Session
     *
     * @return 	blaze\persistence\Session
     */
     public function openSession();
     /**
      * Closes the session factory and all connected sessions
      */
     public function close();
}

?>
