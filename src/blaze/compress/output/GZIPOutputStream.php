<?php

namespace blaze\compress\output;

use blaze\lang\Object;

/**
 * DeflaterOutputStream uses the zlib for writing contents encoded with the
 * gzip method.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class GZIPOutputStream extends DeflaterOutputStream {

    /**
     * Creates a wrapper around the given stream which encodes the contents
     * @param blaze\io\InputStream $stream The wrapped stream
     */
    public function __construct(\blaze\io\OutputStream $stream) {
        parent::__construct($stream);
    }

    /**
     * {@inheritDoc}
     * Writes the encoded data to the underlying stream.
     */
    public function write($str, $off = 0, $len = -1) {
        if ($off !== 0) {
            if ($len === -1)
                return $this->out->write(gzencode(substr($str, $off), 9, \FORCE_GZIP));
            else
                return $this->out->write(gzencode(substr($str, $off, $len), 9, \FORCE_GZIP));
        }
        return $this->out->write(gzencode($str, 9, \FORCE_GZIP));
    }

}

?>
