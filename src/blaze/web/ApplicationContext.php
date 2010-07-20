<?php
namespace blaze\web;
use blaze\lang\Object,
    blaze\lang\Singleton,
    blaze\netlet\http\HttpNetletRequestWrapper,
    blaze\netlet\http\HttpNetletResponseWrapper;

/**
 * Description of ApplicationContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ApplicationContext extends Object implements Singleton{

    private static $instance;
    private $request;
    private $response;
    private $attributes;

    /**
     * Beschreibung
     */
    private function __construct(){
        $this->attributes = array();
        $this->attributes['blaze.web.http.Session'] = 'SimpleSession';
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public function getAttribute($name){
        return $this->attributes[$name];
     }

     /**
      *
      * @return blaze\web\ApplicationContext
      */
    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new ApplicationContext();
        return self::$instance;
    }

    /**
     *
     * @return blaze\web\http\HttpNetletRequest
     */
    public function getRequest(){
        if($this->request == null)
            $this->request = new HttpNetletRequestWrapper();
        return $this->request;
    }

    /**
     *
     * @return blaze\web\http\HttpNetletResponse
     */
    public function getResponse(){
        if($this->response == null)
            $this->response = new HttpNetletResponseWrapper();
        return $this->response;
    }
}

?>
