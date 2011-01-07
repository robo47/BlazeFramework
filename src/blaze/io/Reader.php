<?php

namespace blaze\io;

use blaze\lang\Object;

/**
 * Description of Reader
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class Reader extends Object implements Readable, Closeable, Markable {

    /**
     * Reset the current position to the beginning or to the last mark (if supported).
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public function reset() {

    }

    /**
     * Returns wether the stream is ready for reading or not
     * @return boolean
     */
    public function ready() {
        return true;
    }

    public function mark() {

    }

    public function markSupported() {
        return false;
    }

}

?>
