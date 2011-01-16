<?php

namespace blaze\io;

use blaze\lang\Object;

/**
 * Description of InputStreamReader
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class InputStreamReader extends Reader {

    /**
     *
     * @var blaze\io\InputStream
     */
    protected $is;

    protected function __construct(InputStream $is) {
        $this->is = $is;
    }

    /**
     * Reads contents of a ressource into the buffer or if no buffer is given,
     * returns one char as int.
     *
     * @param 	blaze\lang\StringBuffer $buffer The buffer in which the chars shall be read into
     * @param 	int $off The startpoint of the buffer to start storing
     * @param 	int $len The maximum number of chars to be read
     * @return 	int If no buffer is given, it returns a char represented as int, or -1 if nothing could be read.
     *                  If a buffer is given, if returns the number of chars which were read into it, or -1 if nothing could be read.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public function read(StringBuffer $buffer = null, $off = -1, $len = -1) {
        return $this->is->read($buffer, $off, $len);
    }

    /**
     * Closes the output stream and releases the ressources which are used by it.
     *
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the stream is already closed
     */
    public function close() {
        $this->is->close();
    }

    /**
     * Tries to skip over $n chars and returns the number of chars which were skipped over.
     *
     * @param   long $n The number of chars which shall be skipped
     * @return 	long The number of chars which were skipped
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public function skip(\long $n) {
        return $this->is->skip($n);
    }

}

?>
