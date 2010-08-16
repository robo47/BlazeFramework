<?php
namespace blaze\io;

/**
 * A closeable object is ressource which can be opened and closed such as streams.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
interface Closeable {
    /**
     * Closes the object and releases the ressources which are used by it.
     *
     * @throws	blaze\io\IOException Is thrown when an IO error occurs
     */
     public function close();

     /**
      * Returns wether the object is closed or not.
      * @return boolean
      */
     public function isClosed();
}

?>
