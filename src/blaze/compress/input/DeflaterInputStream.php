<?php

namespace blaze\compress\input;

use blaze\lang\Object;

/**
 * DeflaterInputStream uses the zlib for reading deflated stream contents.
 * Due to the native implementation it can also read gzipped stream contents
 * but should not be used for this.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class DeflaterInputStream extends \blaze\io\input\FilterInputStream {

    /**
     * Creates a wrapper around the given stream which decodes the contents
     * @param blaze\io\InputStream $stream The wrapped stream
     */
    public function __construct(\blaze\io\InputStream $stream) {
        parent::__construct($stream);
    }

    /**
     * Reads and returns decoded data from the stream.
     * @param int $len Number of bytes to read, uses buffer size if not given.
     * @return string .
     */
    public function read($len = -1) {
        return gzdecode($this->in->read($len));
    }


}
?>
