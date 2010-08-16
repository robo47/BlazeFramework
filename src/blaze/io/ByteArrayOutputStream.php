<?php

namespace blaze\io;

use blaze\lang\Object,
 blaze\lang\StringBuffer;

/**
 * Description of ByteArrayOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ByteArrayOutputStream extends OutputStream {

    protected $bytes = '';
    protected $size = 0;
    private $closed = false;
    private $maxSize;

    public function __construct($maxSize = -1) {
        $this->maxSize = $maxSize;
    }

    public function close() {
        $this->closed = true;
    }

    public function isClosed() {
        return $this->closed;
    }

    public function reset() {
        $this->bytes = '';
    }

    public function size() {
        return $this->size;
    }

    public function toString() {
        return $this->bytes;
    }

    public function write($str, $off = 0, $len = -1) {
        if ($len < 0)
            $str = substr($str, $off);
        else
            $str = substr($str, $off, $len);

        $strlen = strlen($str);

        if ($this->maxSize < 0) {
            $possible = $this->maxSize - $this->size;
            if ($strlen > $possible) {
                $str = substr($str, 0, $possible);
                $strlen = $possible;
            }
        }

        $this->bytes .= $str;
        $this->size += $strlen;
    }

    public function flush() {

    }

    public function writeTo(OutputStream $stream) {
        $stream->write($this->bytes);
    }

}
?>
