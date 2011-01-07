<?php

namespace blaze\net;

/**
 * Description of URLStreamHandlerFactory
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface URLStreamHandlerFactory {

    /**
     * @param \blaze\lang\String|string $protocol
     * @return blaze\net\URLStreamHandler
     */
    public function createURLStreamHandler($protocol);
}

?>
