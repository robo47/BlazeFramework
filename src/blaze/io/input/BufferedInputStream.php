<?php

namespace blaze\io\input;

use blaze\lang\Object;

/**
 * Description of BufferedInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
class BufferedInputStream extends \blaze\io\input\FilterInputStream {

    private $bufferSize = 0;
    private $buffer = '';
    private $bufferContentSize = 0;
    private $bufferPos = 0;

    /**
     *
     * @param blaze\io\InputStream $reader The reader
     * @param int $buffsize The size of the buffer which should be used for reading.
     */
    public function __construct(\blaze\io\InputStream $stream, $buffsize = 65536) {
        parent::__construct($stream);
        $this->bufferSize = $buffsize;
    }

//    /**
//     * Reads and returns data from the reader.
//     * @param int $len Number of bytes to read, uses buffer size if not given.
//     * @return string .
//     */
//    public function read($len = -1) {
//        if ($len == -1)
//            $len = $this->bufferSize;
//
//        return $this->in->read($len);
//    }
//
//    public function readInto(\blaze\lang\StringBuffer $buffer = null, $off = -1, $len = -1) {
//        if ($len == -1)
//            $len = $this->bufferSize;
//
//        return $this->in->readInto($buffer, $off, $len);
//    }

    private function fillBufferIfNecessary() {
        if ($this->bufferPos >= $this->bufferContentSize) {
            $this->buffer = $this->in->read($this->bufferSize);
            $this->bufferContentSize = strlen($this->buffer);
            $this->bufferPos = 0;
        }
    }

}

?>
