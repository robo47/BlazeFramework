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
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class PipedInputStream extends InputStream {

    /**
     *
     * @var PipedOutputStream
     */
    private $pos = null;
    private $buffer = '';
    private $cursor = 0;
    private $count = 0;

    public function __construct(PipedOutputStream $pos = null) {
        if($pos !== null)
                $this->connect($pos);
    }
    public function connect(PipedOutputStream $pos) {
        $this->pos = $pos;
        $this->pos->connect($pis);
    }

    public function close() {
        if($this->pos != null) {
            $pos = $this->pos;
            $this->pos = null;
            $pos->close();
        }
    }

    public function receive($data){
        $this->buffer .= $data;
        $this->count += strlen($data);
    }

    public function available(){
        return $this->count - $this->cursor;
    }

    public function read(StringBuffer $buffer = null, $off = 0, $len = -1) {
        if($this->cursor != $this->count){
            $buffer->append(substr($this->buffer,$this->cursor, $this->count - $this->cursor));
            $this->cursor = $this->count;
        }
    }

}

?>
