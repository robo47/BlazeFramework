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

    public function addNetlet($name, \blaze\netlet\Netlet $netlet){
        $this->netlets->put($name, $netlet);
    }

    public function addNetletMapping($URLMapping, $name){
        $this->netletMapping->put($URLMapping, $name);
    }

    public function addFilter($name, \blaze\netlet\Filter $filter){
        $this->filters->put($name, $filter);
    }

    public function addFilterMapping($URLMapping, $name){
        $this->filterMapping->put($URLMapping, $name);
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

    public function getInitParameter($name) {
        return $this->initParams->get($name);
    }

    public function getInitParameterMap() {
        return $this->initParams;
    }

    public function getAttribute($name) {
        return $this->attributes->get($name);
    }

    public function removeAttribute($name) {
        $this->attributes->remove($name);
    }

    public function setAttribute($name, $o) {
        $this->attributes->put($name, $o);
    }

}
?>
