<?php
namespace blaze\io\output;
use blaze\lang\Object;

/**
 * Description of BufferedOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class PrintStream extends \blaze\io\output\FilterOutputStream {

    /**
     * Specifies wether an error occured or not.
     * @var boolean
     */
    private $error = false;

    /**
     * Creates a new PrintStream with the given underlying stream.
     * 
     * @param \blaze\io\OutputStream $stream The wrapped stream
     */
    public function __construct(\blaze\io\OutputStream $stream) {
        parent::__construct($stream);
    }

    /**
     * Returns wether an error has occured with the underlying stream or not.
     *
     * @return boolean
     */
    public function checkError(){
        return $this->error;
    }

    /**
     * Sets that an error has occured on the stream.
     */
    public function setError(){
        $this->error = true;
    }

    /**
     * Prints the given value to the stream and adds a new line.
     *
     * @param mixed|\blaze\lang\Reflectable $val
     */
    public function println($val){
        $this->prints($val);
        $this->prints('\n');
    }

    /**
     * Prints the given value to the stream.
     *
     * @param mixed|\blaze\lang\Reflectable $val
     */
    public function prints($val){
        try{
            $this->out->write($val);
        }catch(blaze\io\IOException $ioe){
            $this->setError();
        }
    }
}

?>
