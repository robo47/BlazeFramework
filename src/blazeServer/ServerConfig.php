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
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ServerConfig extends Object implements Singleton {

    private static $instance;
    private $config;

    /**
     * Description
     */
    private function __construct() {
        $this->config = array('applications' => array('blazeServer' => array('name' => 'BlazeFramework Application Manager', 'running' => true, 'uriPrefix' => '/BlazeFrameworkServer/'),
                                                      'blazeCMS' => array('name' => 'Blazebit Content Management System', 'running' => true, 'uriPrefix' => '/BlazeFrameworkServer/cms/'),
                                                      'schichtverwaltung' => array('name' => 'Schichtverwaltung', 'running' => true, 'uriPrefix' => '/BlazeFrameworkServer/schicht/'),
                                                      'sampleApp' => array('name' => 'Sample Application', 'running' => true, 'uriPrefix' => '/BlazeFrameworkServer/sample/')),
                              'mappings' => array('/BlazeFrameworkServer/sample/*' => 'sampleApp',
                                                  '/BlazeFrameworkServer/cms/*' => 'blazeCMS',
                                                  '/BlazeFrameworkServer/schicht/*' => 'schichtverwaltung',
                                                  '/BlazeFrameworkServer/*' => 'blazeServer'));
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
