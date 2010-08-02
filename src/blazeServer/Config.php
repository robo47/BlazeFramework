<?php
namespace blazeServer;
use blaze\lang\Object,
    blaze\web\application\WebConfig,
    blaze\lang\Singleton;

/**
 * Description of Config
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Config extends Object implements WebConfig, Singleton {
    private static $instance;
    private $configMap;
    private $netletConfigMap;
    private $navigationMap;
    /**
     * Description
     */
    private function __construct(){
        $this->configMap       = array( 'taglibs' => array('blaze.web' => array('renderKitFactory' => 'blaze\\web\\render\\RenderKitFactoryImpl',
                                                                                'renderKits' => array('html4' => 'blaze\\web\\render\\html4\\RenderKitImpl',
                                                                                                      'html5' => 'blaze\\web\\render\\html5\\RenderKitImpl'))),
                                        'views' => array('blazeServer\\view\\TestView' => 'blazeServer\\view\\TestView',
                                                         'blazeServer\\view\\IndexView' => 'blazeServer\\view\\IndexView'));
        $this->netletConfigMap = array( 'netlets' => array(array('name' => 'BlazeNetlet', 'class' => 'blazeServer\\source\\core\\BlazeNetlet', 'initParams' => array())),
                                        'netletMapping' => array('/*' => 'BlazeNetlet'),
                                        'filters' => array(),//array('name' => 'HttpsFilter', 'class' => 'blazeCMS\\filter\\HttpsFilter', 'initParams' => array())),
                                        'filterMapping' => array(),//'/*' => 'HttpsFilter'),
                                        'listeners' => array(),
                                        'initParams' => array(),
                                        'nuts' => array(array('name' => 'test', 'class' => 'blazeServer\\Test', 'scope' => 'application')));
        /**
         * Navigationmap contains the navigationstrings in an orderd from
         * very specific(/test/bla/blub) to simple(/test)
         */
        $this->navigationMap =  array( '/test' => array('view' => 'blazeServer\\view\\TestView',
                                                        'bind' => array(  array('name'      => 'id',
                                                                                'default'   => '0',
                                                                                'object'    => 'myNut.id'),
                                                                          array('name'      => 'name',
                                                                                'default'   => 'test',
                                                                                'object'    => 'myNut2.name')),
            
                                                        'action' => array(array('action'    => 'navigate',
                                                                                'view'      => 'blazeServer\\view\\TestView'),
                                                                          array('action'    => 'success',
                                                                                'view'      => 'blazeServer\\view\\SuccessView'))),
            
                                       '/' =>     array('view' => 'blazeServer\\view\\IndexView'));
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function getConfigurationMap(){
        return $this->configMap;
     }

     public function getNetletConfigurationMap(){
        return $this->netletConfigMap;
     }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function getNavigationMap(){
        return $this->navigationMap;
     }
    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new Config();
        return self::$instance;
    }
}

?>
