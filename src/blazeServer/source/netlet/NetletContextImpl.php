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
    private $netlets = array();
    private $netletMapping = array();
    private $filters = array();
    private $filterMapping = array();
    private $listeners = array();
    private $attributes = array();
    private $initParams;

    public function __construct($initParams, \blazeServer\source\netlet\NetletApplication $netletApplication) {
        $this->initParams = $initParams;
        $this->netletApplication = $netletApplication;
    }

    public function  getNetletApplication() {
        return $this->netletApplication;
    }

    public function addNetlet($name, \blaze\netlet\Netlet $netlet){
        $this->netlets[$name] = $netlet;
    }

    public function addNetletMapping($uriMapping, $name){
        $this->netletMapping[$uriMapping] = $name;
    }

    public function addFilter($name, \blaze\netlet\Filter $filter){
        $this->filters[$name] = $filter;
    }

    public function addFilterMapping($uriMapping, $name){
        $this->filterMapping[$uriMapping] = $name;
    }
    
    public function getNetletMapping() {
        return $this->netletMapping;
    }

    public function getFilterMapping() {
        return $this->filterMapping;
    }

    public function getNetlets() {
        return $this->netlets;
    }

    public function getFilters() {
        return $this->filters;
    }

    public function getListeners() {
        return $this->listeners;
    }

    /**
     * @todo Persist for the server
     */
    public function addListener($name, $listener) {
        $this->listeners[$name] = $listener;
    }

    public function getInitParameter($name, $postType = null) {
        if(!array_key_exists($name, $this->initParams))
                return null;
        return $this->initParams[$name];
    }

    public function getInitParameterMap() {
        return $this->initParams;
    }

    public function getAttribute($name) {
        if(!array_key_exists($name, $this->attributes))
                return null;
        return $this->attributes[$name];
    }

    public function removeAttribute($name) {
        unset($this->attributes[$name]);
    }

    public function setAttribute($name, $o) {
        $this->attributes[$name] = $o;
    }

}
?>
