<?php
namespace blaze\io;
use blaze\io\OutputStream;

/**
 * Description of PipedOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class PipedOutputStream extends OutputStream {

    /**
     *
     * @var PipedInputStream
     */
    private $pis = null;

    public function __construct(PipedInputStream $pis){
        if($pis !== null)
                $this->connect($pis);
    }

    public function connect(PipedIputStream $pis){
        $this->pis = $pis;
        $this->pis->connect($this);
    }

    public function close() {
        if($this->pis != null) {
            $pis = $this->pis;
            $this->pis = null;
            $pis->close();
        }
    }
    public function flush() { }
    public function write($str, $off = 0, $len = -1) {
        $this->pis->receive($str);
    }
}

?>
