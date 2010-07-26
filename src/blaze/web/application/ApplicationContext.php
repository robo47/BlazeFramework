<?php
namespace blaze\web\application;
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
class ApplicationContext extends Object{

    private $request;
    private $response;
    private $application;
    private $elContext;
    private $attributes;

    // See FacesContext

    /**
     * Beschreibung
     */
    public function __construct(Application $application){
        $this->application = $application;

        $conf = $this->application->getConfig()->getNetletConfigurationMap();
        $variableMapper = new \blaze\util\HashMap();

        foreach($conf['beacons'] as $beacon){
            $variableMapper->set($beacon['name'], \blaze\lang\ClassWrapper::forName($beacon['class'])->newInstance());
        }

        $this->elContext = new \blaze\web\el\ELContext($variableMapper);
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
         if(!array_key_exists($name, $this->attributes))
                 return null;
        return $this->attributes[$name];
     }

     public function setAttribute($name, $value){
         $this->attributes[$name] = $value;
     }

     public function removeAttribute($name){
         unset($this->attributes[$name]);
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

    public function getApplication() {
        return $this->application;
    }

    public function getElContext() {
        return $this->elContext;
    }


}

?>
