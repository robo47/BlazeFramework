<?php
namespace blaze\web;
use blaze\lang\Object,
    blaze\lang\StaticInitialization,
    blaze\lang\Singleton,
    blaze\io\File;

/**
 * Description of JSContainer
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author Christian Beikov
 * @todo    Implementation and documentation.
 */
class JSContainer extends Object implements Singleton{

    private static $instance;
    private $content;

    private function __construct(){
        
    }
    /**
     *
     * @return blaze\web\JSContainer
     */
    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new JSContainer();
        return self::$instance;
    }
    public function addCode($code){
        $this->content .= $code;
    }
   public function getContent(){
       return $this->content;
   }


}
?>
