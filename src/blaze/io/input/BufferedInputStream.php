<?php

namespace blaze\io\input;

use blaze\lang\Object;

/**
 * Description of BufferedInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class BufferedInputStream extends \blaze\io\InputStream {

    private $bufferSize = 0;
    private $buffer = '';
    private $bufferContentSize = 0;
    private $bufferPos = 0;
    /**
     * @var blaze\io\InputStream
     */
    private $in;

    /**
     *
     * @param blaze\io\InputStream $reader The reader
     * @param int $buffsize The size of the buffer which should be used for reading.
     */
    public function __construct(\blaze\io\InputStream $stream, $buffsize = 65536) {
        $this->in = $stream;
        $this->bufferSize = $buffsize;
    }

    /**
     * Reads and returns data from the reader.
     * @param int $len Number of bytes to read, uses buffer size if not given.
     * @return string .
     */
    public function read($len = -1) {
        if ($len == -1)
            $len = $this->bufferSize;

        return $this->in->read($len);
    }

    public function readInto(\blaze\lang\StringBuffer $buffer, $off = -1, $len = -1) {
        if ($len == -1)
            $len = $this->bufferSize;

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

    private function fillBufferIfNecessary() {
        if ($this->bufferPos >= $this->bufferContentSize) {
            $this->buffer = $this->in->read($this->bufferSize);
            $this->bufferContentSize = strlen($this->buffer);
            $this->bufferPos = 0;
        }
    }


}
?>
