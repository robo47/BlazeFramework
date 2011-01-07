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
class BufferedOutputStream extends \blaze\io\output\FilterOutputStream {

    /**
     * The size of the buffer in kb.
     */
    private $bufferSize = 0;

    public function __construct(\blaze\io\OutputStream $stream, $buffsize = 8192) {
        parent::__construct($stream);
        $this->bufferSize = $buffsize;
    }

}

?>
