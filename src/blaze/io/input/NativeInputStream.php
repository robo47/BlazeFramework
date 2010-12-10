<?php

namespace blaze\io\input;

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
 */
class NativeInputStream extends \blaze\io\InputStream {

    protected $stream;
    protected $mark = 0;
    private $position = 0;

    public function __construct($streamUrl, $binary = true) {
        $this->stream = fopen($streamUrl, 'r' . $binary ? 'b' : '');
        if ($this->stream === false) {
            $this->stream = null;
            throw new \blaze\io\IOException('Could not open ' . $streamUrl . ':' . $php_errormsg);
        }
    }

    public function close() {
        if($this->stream == null)
                return;
        if (fclose($this->stream) === false)
            throw new \blaze\io\IOException('Closing failed');
        $this->stream = null;
    }

    public function isClosed() {
        return $this->stream == null;
    }

    public function read($len = -1) {
        $this->checkClosed();
        if (feof($this->stream))
            return '';

        if ($len == -1) {
            $result = '';
            while (!feof($this->stream)) {
                $result .= fread($this->stream, 8192);
                $this->position = ftell($this->stream);
            }
        } else {
            $result = fread($this->stream, $len);
            $this->position = ftell($this->stream);
        }

        return $result;
    }

    /**
     * Returns the number of chars which can be read from the stream.
     *
     * @return 	int The number of chars which are available for read.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public function available() {
        $this->checkClosed();
        return feof($this->stream) ? 0 : -1;
    }

    /**
     * Tries to skip over $n chars and returns the number of chars which were skipped over.
     *
     * @param   long $n The number of chars which shall be skipped
     * @return 	long The number of chars which were skipped
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public function skip($n) {
        $this->checkClosed();
        $start = $this->position;

        $ret = fseek($this->stream, $n, SEEK_CUR);
        if ($ret === -1)
            return -1;

        $this->position = ftell($this->stream);

        if ($start > $this->position)
            $skipped = $start - $this->position;
        else
            $skipped = $this->position - $start;

        return $skipped;
    }

    public function mark() {
        if (!$this->markSupported()) {
            throw new \blaze\io\IOException($this->getClass()->getName() . " does not support mark() and reset() methods.");
        }
        $this->mark = $this->position;
    }

    public function markSupported() {
        return false;
    }

    public function reset() {
        if (!$this->markSupported()) {
            throw new \blaze\io\IOException($this->getClass()->getName() . " does not support mark() and reset() methods.");
        }
        fseek($this->stream, SEEK_SET, $this->mark);
        $this->position = $this->mark;
        $this->mark = 0;
    }

}
?>
