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

    public function readSession($id){
        $this->session = unserialize(\blazeCMS\source\dao\Dao::getInstance()->getSession($id));
    }
    public function saveSession(){
        \blazeCMS\source\dao\Dao::getInstance()->setSession($this->session->getId(), serialize($this->session));
    }
    public function removeSession(){
        \blazeCMS\source\dao\Dao::getInstance()->removeSession($this->session->getId());
    }
    public function gc($maxLifetime){
        return true;
    }

    public function getCurrentSession($cookies, $create = false) {
        if($this->session == null){
            $sessionId = null;

            foreach ($cookies as $cookie){
                if ($cookie->getName()->compareTo(self::SESSION_NAME) == 0){
                    $sessionId = $cookie->getValue();
                    break;
                }
            }

            if($sessionId != null)
                $this->readSession($sessionId);

            if($this->session == null && $create){
//                session_start();
                $this->session = new HttpSessionImpl($this, hash('sha512',md5(uniqid()).sha1(uniqid())));
//                $params = session_get_cookie_params();
//                setcookie(session_name(), '', 0, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
//                session_destroy();
            }
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
