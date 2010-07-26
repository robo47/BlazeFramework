<?php
namespace blaze\netlet\http;
use blaze\lang\Object;

/**
 * Description of HttpSessionHandlerImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class HttpSessionHandlerImpl extends Object implements HttpSessionHandler {

    /**
     *
     * @var blaze\netlet\http\HttpSessionHandlerImpl
     */
    private static $instance = null;
    private $session;

    private function __construct(){
        session_name('BBSESSION');
        session_set_cookie_params('3600',null,null,true,true);
        session_start();
        $this->session = new HttpSessionImpl($this);
    }

    public function getSession(){
        return $this->session;
    }

    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new HttpSessionHandlerImpl();
        return self::$instance;
    }
}

?>
