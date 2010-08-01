<?php
namespace blaze\netlet;
use blaze\lang\Object,
    blaze\lang\String,
    blaze\io\OutputStream;

/**
 * Description of NetletOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NetletOutputStream extends OutputStream {
    private static $MAX_SIZE = 5242880; // 5 MB
    private $output;
    private $closed;
    private $response;

    /**
     * Opens a new memory stream with the the max value of 5 megabyte.
     * If that failed, an IOException is thrown.
     * The memory stream will be temporarly saved in a file if the defined
     * max size of the memory stream is used.
     *
     * @throws blaze\io\IOException Is thrown when the stream creation failed.
     */
    public function __construct(NetletResponse $response){
        $this->output = fopen('php://temp/maxmemory'.self::$MAX_SIZE, 'r+');
        if(!$this->output)
                throw new \blaze\io\IOException();
        $this->closed = false;
        $this->response = $response;
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\io\IOException
     * @todo	Check which method is faster
     */
     public function write($buf, $off = 0, $len = -1){
         //Maybe faster?
//         if($off == 0 && $len == -1)
//            $this->output .= $buf;
//         else
//            $this->output .= String::asWrapper($buf)->substring($off, $len)->toNative();

//         ob_start();
//         echo $this->output;
//         echo String::asWrapper($buf)->substring($off, $len)->toNative();
//         $this->output = ob_get_contents();
//         ob_end_clean();

        if($this->closed)
                throw new \blaze\io\IOException();
         fwrite($this->output, $buf);
    }

    /**
     * Flushes the stream content to the clients browser
     *
     * @throws	blaze\io\IOException Is thrown when the stream is already closed
     */
     public function flush(){
         if($this->closed)
                throw new \blaze\io\IOException();
         $contentLength = ftell($this->output);
         rewind($this->output);
         $this->response->setContentLength($contentLength);
         echo stream_get_contents($this->output);
         //unset($this->output);
         //$this->output = "";
     }

     /**
      * Flushes and then closes the stream
      *
      * @throws blaze\io\IOException Is thrown when the stream is already closed
      */
     public function close(){
         if($this->closed)
                throw new \blaze\io\IOException();
         
         $this->flush();
         if(!fclose($this->output))
                 throw new \blaze\io\IOException();
         $this->closed = true;
    }
}

?>
