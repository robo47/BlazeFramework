<?php

namespace blaze\io\output;

use blaze\io\OutputStream;

/**
 * Description of NativeOutputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class FilterNativeOutputStream extends \blaze\io\output\NativeOutputStream {

    public function __construct($stream) {
        $this->stream = $stream;
    }

    public function getNativeStream(){
        return $this->stream;
    }

}

?>
