<?php

namespace blazeServer\source\netlet;

use blaze\lang\Object;
use blaze\netlet\NetletContext;

/**
 * Description of NetletContextImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class NetletContextImpl extends Object implements NetletContext {

    /**
     *
     * @var blazeServer\source\core\NetletApplication
     */
    private $netletApplication;
    private $initParams;
    private $netlets;
    private $netletMapping;
    private $filters;
    private $filterMapping;
    private $listeners;
    private $attributes;

    public function __construct($initParams, \blazeServer\source\netlet\NetletApplication $netletApplication) {
        $this->initParams = $initParams;
        $this->netletApplication = $netletApplication;
        $this->netlets = new \blaze\collections\map\HashMap();
        $this->netletMapping = new \blaze\collections\map\HashMap();
        $this->filters = new \blaze\collections\map\HashMap();
        $this->filterMapping = new \blaze\collections\map\HashMap();
        $this->listeners = new \blaze\collections\lists\ArrayList();
        $this->attributes = new \blaze\collections\map\HashMap();
    }

    public function  getNetletApplication() {
        return $this->netletApplication;
    }

    public function addNetlet(\blaze\lang\String $name, \blaze\netlet\Netlet $netlet){
        $this->netlets->put($name, $netlet);
    }

    public function addNetletMapping(\blaze\lang\String $uriMapping, \blaze\lang\String $name){
        $this->netletMapping->put($uriMapping, $name);
    }

    public function addFilter(\blaze\lang\String $name, \blaze\netlet\Filter $filter){
        $this->filters->put($name, $filter);
    }

    public function addFilterMapping(\blaze\lang\String $uriMapping, \blaze\lang\String $name){
        $this->filterMapping->put($uriMapping, $name);
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

    public function addListener($listener) {
        $this->listeners->add($listener);
    }

    public function getInitParameter(\blaze\lang\String $name) {
        return $this->initParams->get($name);
    }

    public function getInitParameterMap() {
        return $this->initParams;
    }

    public function getAttribute(\blaze\lang\String $name) {
        return $this->attributes->get($name);
    }

    public function removeAttribute(\blaze\lang\String $name) {
        $this->attributes->remove($name);
    }

    public function setAttribute(\blaze\lang\String $name, $o) {
        $this->attributes->put($name, $o);
    }

}
?>
