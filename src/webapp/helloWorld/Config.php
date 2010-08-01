<?php
namespace webapp\helloWorld;
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
    private $navigationMap;
    /**
     * Description
     */
    private function __construct(){
        
        $this->navigationMap =  array( '/test' => array('view' => 'TestView',
                                                        'bind' => array(  array('name'      => 'id',
                                                                                'default'   => '0',
                                                                                'object'    => 'myNut.id'),
                                                                          array('name'      => 'name',
                                                                                'default'   => 'test',
                                                                                'object'    => 'myNut2.name')),
            
                                                        'action' => array(array('action'    => 'navigate',
                                                                                'view'      => 'TestView'),
                                                                          array('action'    => 'success',
                                                                                'view'      => 'SuccessView'))),
            
                                       '/' =>     array('view' => 'IndexView'));
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
