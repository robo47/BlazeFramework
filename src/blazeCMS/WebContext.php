<?php
namespace blazeCMS;
use blaze\lang\Object,
    blaze\lang\String,
    blaze\lang\Singleton;

/**
 * Description of WebContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class WebContext extends Object implements Singleton {

    private static $instance;

    private $dao;
    private $attributes;
    private $theme;
    private $paths;
    private $module;

    /**
     * Description
     */
    private function __construct(){
        $this->dao = GenericDAO::getInstance();
        $this->attributes = array();
        $this->theme = 'default';
        $this->paths = array();
        $this->module = 'index';
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blazeCMS\WebContext Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
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
