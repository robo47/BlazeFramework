<?php
namespace blaze\io;
use blaze\io\InputStream,
    blaze\lang\StringBuffer;

/**
 * Description of PipedInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class PipedInputStream extends ByteArrayInputStream {

    /**
     *
     * @var PipedOutputStream
     */
    private $pos = null;

    public function __construct(PipedOutputStream $pos = null) {
        if($pos !== null)
                $this->connect($pos);
    }
    public function connect(PipedOutputStream $pos) {
        $this->pos = $pos;
        $this->pos->connect($pis);
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
