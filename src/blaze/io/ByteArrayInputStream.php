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

    private $bytes;
    private $closed = false;
    private $position = 0;
    private $count = 0;

    public function __construct($bytes){
        $this->bytes = $bytes;
        $this->count = strlen($bytes);
    }

    public function close(){
        if($this->closed)
            throw new IOException('Stream is already closed.');
        $this->closed = true;
    }

    public function read(StringBuffer $buffer = null, $off = 0, $len = -1) {
        if($this->closed)
            throw new IOException('Stream is already closed.');
        if($buffer === null)
            throw new \blaze\lang\NullPointerException();
        if($off < 0)
            throw new \blaze\lang\IllegalArgumentException('Offset must be equals or greater than zero.');
        $this->position += $off;
        if($len > 0)
            $result = substr($this->bytes, $this->position, $len);
        $result = substr($this->bytes, $this->position);

        $read = strlen($result);
        $this->position += $read;
        $buffer->append($result);
        return $read;
    }

    /**
     * Returns the number of chars which can be read from the stream.
     *
     * @return 	integer The number of chars which are available for read.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function available(){
        if($this->closed)
            throw new IOException('Stream is already closed.');
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
        if($this->closed)
            throw new IOException('Stream is already closed.');
         $this->position += $n;
     }
}

?>
