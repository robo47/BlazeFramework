<?php

namespace blaze\io\input;

use blaze\lang\Object;

/**
 * Description of InputStreamReader
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
class BufferedReader extends \blaze\io\Reader {

    private $bufferSize = 0;
    private $buffer = '';
    private $bufferContentSize = 0;
    private $bufferPos = 0;
    /**
     * @var blaze\io\Reader
     */
    private $in;
    private $lineCount = 0;

    /**
     *
     * @param blaze\io\Reader $reader The reader
     * @param int $buffsize The size of the buffer which should be used for reading.
     */
    public function __construct(\blaze\io\Reader $reader, $buffsize = 65536) {
        $this->in = $reader;
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

    public function skip(\long $n) {
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

    /**
     * Read a line from Reader.
     * @return string
     */
    public function readLine() {
        $this->lineCount++;
        $this->fillBufferIfNecessary();
        $line = '';
        $pos = $this->bufferContentSize;

        while ($this->buffer != '') {
            $pos = strpos($this->buffer, "\n", $this->bufferPos);

            if ($pos === false)
                break;

            $line .= substr($this->buffer, $this->bufferPos);
            $this->fillBufferIfNecessary();
        }

        $line .= substr($this->buffer, $this->bufferPos, $pos - $this->bufferPos);
        $this->bufferPos = $pos + 1;
        return $line;
    }

    public function readLineInto(\blaze\lang\StringBuffer $buffer, $off = -1) {
        $result = $this->readLine();
        $read = strlen($result);

        if ($off < 0)
            $buffer->append($result);
        else
            $buffer->insert($result, $off);

        return $read;
    }

    public function getLineNumber() {
        return $this->lineCount;
    }

    private function fillBufferIfNecessary() {
        if ($this->bufferPos >= $this->bufferContentSize) {
            $this->buffer = $this->in->read($this->bufferSize);
            $this->bufferContentSize = strlen($this->buffer);
            $this->bufferPos = 0;
        }
    }

    /**
     * Reads a single char from the reader.
     * @return string 
     */
    public function readChar() {
        $this->fillBufferIfNecessary();
        return $this->buffer != '' ? $this->buffer[$this->bufferPos++] : '';
    }

}

?>
