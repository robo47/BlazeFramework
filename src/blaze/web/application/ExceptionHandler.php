<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\Singleton,
 blaze\netlet\http\HttpNetletRequestWrapper,
 blaze\netlet\http\HttpNetletResponseWrapper;

/**
 * The ExceptionHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ExceptionHandler extends Object {

    public function __construct() {
        
    }

    public function handle(\blaze\lang\Exception $e) {
        throw $e;
    }

}

?>
