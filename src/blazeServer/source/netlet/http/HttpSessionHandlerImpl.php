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

    public function getCurrentSession($cookies, $create = false) {
        if($this->session == null){
            $sessionId = null;

            foreach ($cookies as $cookie){
                if ($cookie->getName()->compare(self::SESSION_NAME) == 0){
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
