<?php
namespace blaze\io;
use blaze\lang\Object,
    blaze\lang\StringBuffer;

/**
 * Description of ByteArrayInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ByteArrayInputStream extends InputStream {

    protected $bytes;
    protected $count = 0;
    private $closed = false;
    private $position = 0;
    private $mark = 0;

    public function __construct($bytes, $off = 0, $len = -1){
        $this->bytes = $bytes;
        $this->count = strlen($bytes);
    }

    public function close(){
        $this->closed = true;
    }

    public function isClosed() {
        return $this->closed;
    }

    public function read($len = -1) {
        $this->checkClosed();
        if($len > 0 && $len + $this->position <= $this->count)
            $result = substr($this->bytes, $this->position, $len);
        else
            $result = substr($this->bytes, $this->position);

        $read = strlen($result);
        $this->position += $read;
        return $result;
    }

    /**
     * Returns the number of chars which can be read from the stream.
     *
     * @return 	integer The number of chars which are available for read.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function available(){
        $this->checkClosed();
         return $this->count - $this->position;
     }

    /**
     * Tries to skip over $n chars and returns the number of chars which were skipped over.
     *
     * @param   long $n The number of chars which shall be skipped
     * @return 	long The number of chars which were skipped
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function skip($n){
        $this->checkClosed();
         $this->position += $n;
     }

     public function mark() {
         $this->mark = $this->position;
     }

     public function markSupported() {
         return true;
     }

     public function reset() {
         $this->position = $this->mark;
     }

}

?>
