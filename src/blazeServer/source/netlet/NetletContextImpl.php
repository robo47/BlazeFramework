<?php

namespace blazeServer\source\netlet;

use blaze\lang\Object;
use blaze\netlet\NetletContext;

/**
 * Description of NetletContextImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class NetletContextImpl extends Object implements NetletContext {

    /**
     *
     * @var blazeServer\source\core\NetletApplication
     */
    private $netletApplication;
    private $netlets;
    private $netletMapping;
    private $filters;
    private $filterMapping;
    private $listeners;
    private $attributes = array();
    private $initParams;

    public function __construct($initParams, \blazeServer\source\netlet\NetletApplication $netletApplication) {
        $this->initParams = $initParams;
        $this->netletApplication = $netletApplication;
    }

    /**
     * @todo Persist for the server
     */
    public function addNetlet($name, $netletClass) {
        $this->netlets[$name] = $netletClass;
    }

    /**
     * @todo Persist for the server
     */
    public function addNetletMapping($name, $urlPattern) {
        $this->netletMapping[$name][] = $urlPattern;
    }
    
    public function getNetletMapping() {
        $conf = $this->netletApplication->getConfig();
        $netletMap = $conf->getNetletConfigurationMap();
        return $netletMap['netletMapping'];
        //return $this->netletMapping;
    }

    /**
     * @todo Persist for the server
     */
    public function addFilter($name, $filterClass) {
        $this->filters[$name] = $filterClass;
    }

    /**
     * @todo Persist for the server
     */
    public function addFilterMapping($name, $urlPattern) {
        $this->filterMapping[$name][] = $urlPattern;
    }

    public function getFilterMapping() {
        $conf = $this->netletApplication->getConfig();
        $netletMap = $conf->getNetletConfigurationMap();
        return $netletMap['filterMapping'];
        //return $this->filterMapping;
    }

    /**
     * @todo Persist for the server
     */
    public function addListener($name, $listenerClass) {
        $this->listeners[$name] = $listenerClass;
    }

    public function getInitParameter($name, $postType = null) {
        $conf = $this->netletApplication->getConfig();
        $netletMap = $conf->getNetletConfigurationMap();

        if(!array_key_exists($name, $netletMap['initParams']))
                return null;
        return $netletMap['initParams'][$name];

//        if(!array_key_exists($name, $this->initParams))
//                return null;
//        return $this->initParams[$name];
    }

    public function getInitParameterMap() {
        $conf = $this->netletApplication->getConfig();
        $netletMap = $conf->getNetletConfigurationMap();
        return $netletMap['initParams'];
        //return $this->initParams;
    }

    public function getAttribute($name) {
        if(!array_key_exists($name, $this->attributes))
                return null;
        return $this->attributes[$name];
    }

    /**
     * @todo Persist for the server
     */
    public function removeAttribute($name) {
        unset($this->attributes[$name]);
    }

    /**
     * @todo Persist for the server
     */
    public function setAttribute($name, $o) {
        $this->attributes[$name] = $o;
    }

}
?>
