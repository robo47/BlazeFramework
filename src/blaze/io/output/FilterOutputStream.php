<?php
namespace blaze\io\output;
use blaze\lang\Object;

/**
 * Description of FilterOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class FilterOutputStream extends \blaze\io\OutputStream {

    /**
     * @var blaze\io\OutputStream The OutputStream we are buffering output to.
     */
    protected $out;

    public function __construct(\blaze\io\OutputStream $stream) {
        $this->out = $stream;
    }

    public function write($str, $off = 0, $len = -1) {
        return $this->out->write($str, $off, $len);
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
