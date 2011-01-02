<?php
namespace blaze\io;

/**
 * A flushable object is ressource which buffers contents before they are written to it.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
interface Flushable {
    /**
     * Flushes the buffered content to the underlying ressource.
     *
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the stream is already closed
     */
     public function flush();
}

?>
