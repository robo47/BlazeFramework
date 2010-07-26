<?php
namespace blazeServer;
use blaze\lang\Object,
    blaze\web\WebConfig,
    blaze\lang\Singleton;

/**
 * Description of Config
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Config extends Object implements WebConfig, Singleton {
    private static $instance;
    private $configMap;
    private $netletConfigMap;
    private $navigationMap;
    /**
     * Beschreibung
     */
    private function __construct(){
        $this->configMap       = array( '' => '');
        $this->netletConfigMap = array( 'netlets' => array(array('name' => 'BlazeNetlet', 'class' => 'blazeServer\\source\\core\\BlazeNetlet', 'initParams' => array())),
                                        'netletMapping' => array('/*' => 'BlazeNetlet'),
                                        'filters' => array(array('name' => 'HttpsFilter', 'class' => 'blazeCMS\\filter\\HttpsFilter', 'initParams' => array())),
                                        'filterMapping' => array('/*' => 'HttpsFilter'),
                                        'listeners' => array(),
                                        'initParams' => array(),
                                        'beacons' => array(array('name' => 'test', 'class' => 'blazeServer\\Test', 'scope' => 'application')));
        /**
         * Navigationmap contains the navigationstrings in an orderd from
         * very specific(/test/bla/blub) to simple(/test)
         */
        $this->navigationMap =  array( '/test' => array('view' => 'TestView',
                                                        'bind' => array(  array('name'      => 'id',
                                                                                'default'   => '0',
                                                                                'object'    => 'myBeacon.id'),
                                                                          array('name'      => 'name',
                                                                                'default'   => 'test',
                                                                                'object'    => 'myBeacon2.name')),
            
                                                        'action' => array(array('action'    => 'navigate',
                                                                                'view'      => 'blazeServer\\view\\TestView'),
                                                                          array('action'    => 'success',
                                                                                'view'      => 'blazeServer\\view\\SuccessView'))),
            
                                       '/' =>     array('view' => 'blazeServer\\view\\IndexView'));
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
     public function getConfigurationMap(){
        return $this->configMap;
     }

     public function getNetletConfigurationMap(){
        return $this->netletConfigMap;
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
