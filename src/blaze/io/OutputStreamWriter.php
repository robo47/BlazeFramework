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
class OutputStreamWriter extends Writer {
        /**
     *
     * @var blaze\io\OutputStream
     */
    protected $os;

    public function __construct(OutputStream $os){
        $this->os = $os;
    }

    /**
     * Writes the value of $str into the ressource which is used by the writer.
     * With $off you can define a start point in $str and $len specifies the number of chars you want to
     * write.
     *
     * @param 	blaze\lang\String|string $str The value you want to write
     * @param 	int $off The start offset in the data
     * @param 	int $len The number of chars to write, if this value is -1 then $str is written from $off to the end of $str
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the stream is already closed
     */
     public function write($str, $off = 0, $len = -1){
         $this->os->write($str, $off, $len);
     }

    /**
     * Flushes the output stream so any buffered content is written.
     *
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the stream is already closed
     */
     public function flush(){
         $this->os->flush();
     }

    /**
     * Closes the output stream and releases the ressources which are used by it.
     *
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the stream is already closed
     */
     public function close(){
         $this->os->close();
     }

     public function isClosed() {
         return $this->os->isClosed();
     }


}

?>
