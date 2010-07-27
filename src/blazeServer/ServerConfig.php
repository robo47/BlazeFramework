<?php

namespace blazeServer;

use blaze\lang\Object,
 blaze\lang\Singleton;

/**
 * Description of ServerConfig
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ServerConfig extends Object implements Singleton {

    private static $instance;
    private $config;

    /**
     * Beschreibung
     */
    private function __construct() {
        $this->config = array('applications' => array('blazeServer' => array('name' => 'BlazeFramework Application Manager', 'running' => true),
                                                      'blazeCMS' => array('name' => 'Blazebit Content Management System', 'running' => true)),
                              'mappings' => array('/BlazeFrameworkServer/server/' => 'blazeServer', '/BlazeFrameworkServer/*' => 'blazeCMS'));
    }

    public function getConfig() {
        return $this->config;
    }

    public static function getInstance() {
        if (self::$instance == null)
            self::$instance = new ServerConfig();
        return self::$instance;
    }

}
?>
