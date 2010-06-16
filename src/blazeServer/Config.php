<?php
namespace blazeServer;
use blaze\lang\Object,
    blaze\web\WebConfig,
    blaze\lang\Singleton;

/**
 * Description of Config
 *
 * @author  RedShadow
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
    private $navigationMap;
    /**
     * Beschreibung
     */
    private function __construct(){
        $this->configMap =      array( '' => '');
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
                                                                                'view'      => 'TestView'),
                                                                          array('action'    => 'success',
                                                                                'view'      => 'SuccessView'))),
            
                                       '/' =>     array('view' => 'IndexView'));
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
