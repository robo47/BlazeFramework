<?php

namespace blaze\io\output;

use blaze\lang\Object;

/**
 * Description of OutputStreamWriter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
class BufferedWriter extends \blaze\io\Writer {

    /**
     * The size of the buffer in kb.
     */
    private $bufferSize = 0;
    /**
     * @var blaze\io\Writer The Writer we are buffering output to.
     */
    private $out;

    public function __construct(\blaze\io\Writer $writer, $buffsize = 8192) {
        $this->out = $writer;
        $this->bufferSize = $buffsize;
    }

    public function write($str, $off = 0, $len = -1) {
        return $this->out->write($str, $off, $len);
    }

    public function writeLine($str, $off = 0, $len = -1) {
        $result = $this->out->write($str, $off, $len);
        $this->write(PHP_EOL);
        return $result;
    }

    public function flush() {
        $this->out->flush();
    }

    public function close() {
        return $this->out->close();
    }

    public function isClosed() {
        return $this->out->isClosed();
    }

}

?>
