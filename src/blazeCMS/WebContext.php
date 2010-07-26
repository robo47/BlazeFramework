<?php
namespace blazeCMS;
use blaze\lang\Object,
    blaze\lang\String,
    blaze\lang\Singleton,
    blazeCMS\dao\GenericDAO;

/**
 * Description of WebContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class WebContext extends Object implements Singleton {

    private static $instance;

    private $dao;
    private $attributes;
    private $theme;
    private $paths;
    private $module;

    /**
     * Beschreibung
     */
    private function __construct(){
        $this->dao = GenericDAO::getInstance();
        $this->attributes = array();
        $this->theme = 'default';
        $this->paths = array();
        $this->module = 'index';
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blazeCMS\WebContext Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public static function getInstance(){
        if(self::$instance == null)
            self::$instance = new WebContext();
        return self::$instance;
     }

     /**
      *
      * @param blaze\lang\String|string $name
      * @param blaze\lang\Object $value
      * @return WebContext
      */
     public function setAttribute($name, Object $value){
         $this->attributes[String::asNative($name)] = $value;
         return $this;
     }

     /**
      *
      * @param blaze\lang\String|string $name
      * @return blaze\lang\Object
      */
     public function getAttribute($name){
         return isset($this->attributes[String::asNative($name)]) ? $this->attributes[String::asNative($name)] : null;
     }

     /**
      *
      * @param blaze\lang\String|string $name
      * @param blaze\lang\String|string $value
      * @return WebContext
      */
     public function setParameter($name, $value){
         $this->attributes[String::asNative($name)] = String::asWrapper($value);
         return $this;
     }

     /**
      *
      * @param blaze\lang\String|string $name
      * @return blaze\lang\String
      */
     public function getParameter($name){
         return isset($this->attributes[String::asNative($name)]) ? $this->attributes[$name] : null;
     }
}

?>
