<?php

namespace blaze\io\input;

use blaze\lang\Object,
 blaze\lang\StringBuffer;

/**
 * Description of ByteArrayInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class FilterNativeInputStream extends \blaze\io\input\NativeInputStream {

    public function __construct($stream) {
        $this->stream = $stream;
    }

    public function getNativeStream(){
        return $this->stream;
    }
}

?>
