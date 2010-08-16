<?php
namespace blaze\io;
use blaze\lang\Object;

/**
 * Description of OutputStreamWriter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class BufferedWriter extends Writer {
     /**
     * The size of the buffer in kb.
     */
    private $bufferSize = 0;

    /**
     * @var blaze\io\Writer The Writer we are buffering output to.
     */
    private $out;

    public function __construct(Writer $writer, $buffsize = 8192) {
        $this->out = $writer;
        $this->bufferSize = $buffsize;
    }

    public function write($str, $off = 0, $len = -1) {
        return $this->out->write($buf, $off, $len);
    }

    public function writeLine() {
        $result = $this->out->write($buf, $off, $len);
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
