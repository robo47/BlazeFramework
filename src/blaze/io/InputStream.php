<?php

namespace blaze\io;

use blaze\lang\Object,
 blaze\lang\StringBuffer;

/**
 * Description of InputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @see     blaze\io\OutputStream
 * @since   1.0

 */
abstract class InputStream extends Object implements Readable, Closeable, Markable {

    /**
     * Returns the number of chars which can be read from the stream.
     *
     * @return 	int The number of chars which are available for read and -1 for unknown.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public abstract function available();

    /**
     * Tries to skip over $n chars and returns the number of chars which were skipped over.
     *
     * @param   long $n The number of chars which shall be skipped
     * @return 	long The number of chars which were skipped
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public abstract function skip($n);

    public function readInto(StringBuffer $buffer, $off = -1, $len = -1) {
        $result = $this->read($len);
        $read = strlen($result);

        if ($off < 0)
            $buffer->append($result);
        else
            $buffer->insert($result, $off);

        return $read;
    }

    /**
     * Reset the current position to the beginning or to the last mark (if supported).
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public function reset() {

    }

    public function mark() {

    }

    public function markSupported() {
        return false;
    }

    protected function checkClosed() {
        if ($this->isClosed())
            throw new IOException($this->toString() . ' is already closed.');
    }

}

?>
