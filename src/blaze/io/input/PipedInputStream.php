<?php
namespace blaze\io\input;
use blaze\io\InputStream,
    blaze\lang\StringBuffer;

/**
 * Description of PipedInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class PipedInputStream extends ByteArrayInputStream {

    /**
     *
     * @var PipedOutputStream
     */
    private $pos = null;

    public function __construct(\blaze\io\output\PipedOutputStream $pos = null) {
        if($pos !== null)
                $this->connect($pos);
    }
    public function connect(\blaze\io\output\PipedOutputStream $pos) {
        if($this->pos == null){
            $this->pos = $pos;
            $this->pos->connect($this);
        }
    }

    public function isClosed() {
        return $this->pos === null;
    }

    public function close() {
        if($this->pos != null) {
            $pos = $this->pos;
            $this->pos = null;
            $pos->close();
        }
    }

    public function receive($data){
        $this->checkClosed();
        $this->bytes .= $data;
        $this->count += strlen($data);
    }

}

?>
