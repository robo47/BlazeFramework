<?php

namespace blaze\netlet\http;

use blaze\lang\Singleton;

/**
 * Description of HttpSessionHandler
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface HttpSessionHandler {

    /**
     * @param boolean $create Indicates wether a session shall be created when no session is available or not.
     */
    public function getCurrentSession($cookies, $create = false);
}

?>
