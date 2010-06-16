<?php
namespace blaze\io;

/**
 * A closeable object is ressource which can be opened and closed such as streams.
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
interface Closeable {
    /**
     * Closes the stream and releases the ressources which are used by the stream.
     *
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the stream is already closed
     */
     public function close();
}

?>
