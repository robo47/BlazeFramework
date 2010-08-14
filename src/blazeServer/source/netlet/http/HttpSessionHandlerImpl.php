<?php

namespace blazeServer\source\netlet\http;

use blaze\lang\Object;

/**
 * Description of HttpSessionHandlerImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class HttpSessionHandlerImpl extends Object implements \blaze\netlet\http\HttpSessionHandler {
    const SESSION_NAME = 'BLAZESESSION';
    
    /**
     *
     * @var blaze\netlet\http\HttpSessionHandlerImpl
     */
    private static $instance = null;
    private $session = null;

    private function __construct() {

    }

    public function getCurrentSession($cookies, $create = false) {
        $sessionExist = false;

        foreach ($cookies as $cookie)
            if ($cookie->getName()->compareTo(self::SESSION_NAME) == 0)
                $sessionExist = true;

        if ($sessionExist || $create) {
            session_name(self::SESSION_NAME);
            session_set_cookie_params('3600', null, null, true, true);
            session_start();
            $this->session = new HttpSessionImpl($this);
        }

        return $this->session;
    }

    public static function getInstance() {
        if (self::$instance == null)
            self::$instance = new HttpSessionHandlerImpl();
        return self::$instance;
    }

}
?>
