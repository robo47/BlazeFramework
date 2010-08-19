<?php
namespace blaze\io\output;
use blaze\lang\Object;

/**
 * Description of BufferedOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class BufferedOutputStream extends \blaze\io\OutputStream {
     /**
     * The size of the buffer in kb.
     */
    private $bufferSize = 0;

    /**
     * @var blaze\io\OutputStream The OutputStream we are buffering output to.
     */
    private $out;

    public function __construct(\blaze\io\OutputStream $stream, $buffsize = 8192) {
        $this->out = $stream;
        $this->bufferSize = $buffsize;
    }

    public function write($str, $off = 0, $len = -1) {
        return $this->out->write($buf, $off, $len);
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
