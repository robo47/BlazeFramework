<?php

namespace blaze\compress\input;

use blaze\lang\Object;

/**
 * Description of DeflaterInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class DeflaterInputStream extends \blaze\io\input\FilterInputStream {

    /**
     *
     * @param blaze\io\InputStream $reader The reader
     */
    public function __construct(\blaze\io\InputStream $stream) {
        parent::__construct($stream);
    }

    /**
     * Reads and returns data from the reader.
     * @param int $len Number of bytes to read, uses buffer size if not given.
     * @return string .
     */
    public function read($len = -1) {
        return gzdecode($this->in->read($len));
    }


}
?>
