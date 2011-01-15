<?php

namespace blazeServer\source\netlet\http;

use blaze\lang\Object;

/**
 * Description of HttpSessionHandlerImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class HttpSessionHandlerImpl extends Object implements \blaze\netlet\http\HttpSessionHandler {
    const SESSION_NAME = 'BLAZESESSION';
    
    private $session = null;

    public function __construct(){}

    public function readSession($id){
        session_name(self::SESSION_NAME);
        session_id($id);
        ini_set('session.use_cookies', '0');
        session_start();
        $this->session = new HttpSessionImpl($this, session_id(), $_SESSION);
    }

    public function saveSession(){
        foreach($this->session->getSessionMap() as $key => $val)
                $_SESSION[$key] = $val;

//        setcookie(self::SESSION_NAME, '');
        session_write_close();
    }

    public function removeSession(){
        session_destroy();
    }

    public function gc($maxLifetime){
        return true;
    }

    public function getCurrentSession(\blaze\netlet\http\HttpNetletRequest $request, $create = false) {
        if($this->session == null){
            $sessionId = null;

            foreach ($request->getCookies() as $cookie){
                if ($cookie->getName()->compareTo(self::SESSION_NAME) == 0){
                    $sessionId = $cookie->getValue();
                    break;
                }
            }

            if($sessionId != null){
                $this->readSession($sessionId);
            }
            if($this->session == null && $create){
                session_name(self::SESSION_NAME);
                session_id(hash('sha512',md5(uniqid()).sha1(uniqid())));
                ini_set('session.use_cookies', '0');
                session_start();
                $this->session = new HttpSessionImpl($this, session_id(), $_SESSION);
            }
        }
        return $this->session;
    }

}
?>
