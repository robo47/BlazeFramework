<?php

namespace blaze\io\input;

use blaze\lang\Object;

/**
 * Description of FilterInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class FilterInputStream extends \blaze\io\InputStream {

    /**
     * @var blaze\io\InputStream
     */
    protected $in;

    /**
     *
     * @param blaze\io\InputStream $stream The stream
     */
    public function __construct(\blaze\io\InputStream $stream) {
        $this->in = $stream;
    }

    /**
     * Reads and returns data from the reader.
     * @param int $len Number of bytes to read, uses buffer size if not given.
     * @return string .
     */
    public function read($len = -1) {
        return $this->in->read($len);
    }

    public function readInto(\blaze\lang\StringBuffer $buffer, $off = -1, $len = -1) {
        return $this->in->readInto($buffer, $off, $len);
    }

    public function skip($n) {
        return $this->in->skip($n);
    }

    public function reset() {
        return $this->in->reset();
    }

    public function close() {
        return $this->in->close();
    }

    public function isClosed() {
        return $this->in->isClosed();
    }

}
?>
