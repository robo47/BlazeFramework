<?php
namespace blaze\io\output;
use blaze\io\OutputStream;

/**
 * Description of NativeOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NativeOutputStream extends \blaze\io\OutputStream {

    protected $stream = null;

    public function __construct($streamUrl, $append = false, $binary = true) {
        $this->stream = fopen($streamUrl, $append ? 'a' : 'w' . $binary ? 'b' : '');
        if ($this->stream === false) {
            $this->stream = null;
            throw new \blaze\io\IOException('Could not open ' . $streamUrl . ':' . $php_errormsg);
        }
    }

    public function close() {
        if($this->stream == null)
                return;
        $this->flush();
        if (fclose($this->stream) === false)
            throw new \blaze\io\IOException('Closing failed');
        $this->stream = null;
    }

    public function isClosed() {
        return $this->stream == null;
    }

    public function flush() {
        if (fflush($this->stream) === false) {
            throw new \blaze\io\IOException('Could not flush stream');
        }
    }
    public function write($str, $off = 0, $len = -1) {
        $str = \blaze\lang\String::asNative($str);
        
        if ($off > 0){
            if($len > 0)
                $str = substr($str, $off, $len);
            else
                $str = substr($str, $off);
        }

        if ( fwrite($this->stream, $str) === false ) {
            throw new \blaze\io\IOException('Error writing to stream.');
        }
    }
}

?>
