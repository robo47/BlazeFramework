<?php
namespace sampleApp;
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
    /**
     * Description
     */
    private function __construct(){
        $this->configMap       = array( 'taglibs' => array('blaze.web' => array('renderKitFactory' => 'blaze\\web\\render\\RenderKitFactoryImpl',
                                                                                'renderKits' => array('html4' => 'blaze\\web\\render\\html4\\RenderKitImpl',
                                                                                                      'html5' => 'blaze\\web\\render\\html5\\RenderKitImpl'))),
                                        'nuts' => array(),
                                        'listeners' => array(),
                                        'tagDecorators' => array(),
                                        /**
                                         * Navigation part contains the navigationstrings in an orderd from
                                         * very specific(/test/bla/blub) to simple(/test)
                                         */
                                        'navigation' => array( '/*' =>     array('view' => 'index.xhtml',
                                                                                'action' => array(array('action'    => 'navigate',
                                                                                                        'view'      => 'nav.xhtml'),
                                                                                                  array('action'    => 'back',
                                                                                                        'view'      => 'index.xhtml'),
                                                                                                  array('action'    => 'success',
                                                                                                        'view'      => 'success.xhtml')))
                                            ));
        $this->netletConfigMap = array( 'netlets' => array(array('name' => 'BlazeNetlet', 'class' => 'blazeServer\\source\\core\\BlazeNetlet', 'initParams' => array())),
                                        'netletMapping' => array('/*' => 'BlazeNetlet'),
                                        'filters' => array(),//array('name' => 'HttpsFilter', 'class' => 'blazeCMS\\filter\\HttpsFilter', 'initParams' => array())),
                                        'filterMapping' => array(),//'/*' => 'HttpsFilter'),
                                        'listeners' => array(),
                                        'initParams' => array());
    }

     public function getConfigurationMap(){
        return $this->configMap;
     }

     public function getNetletConfigurationMap(){
        return $this->netletConfigMap;
     }

    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new Config();
        return self::$instance;
    }
}

?>
