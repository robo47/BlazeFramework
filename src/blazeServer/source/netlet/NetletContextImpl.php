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
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class NetletContextImpl extends Object implements NetletContext {

    private $netlets;
    private $netletMapping;
    private $filters;
    private $filterMapping;
    private $listeners;
    private $attributes;
    private $initParams;

    public function __construct($initParams) {
        $this->initParams = $initParams;
    }

    public function addNetlet($name, $netletClass) {
        $this->netlets[$name] = $netletClass;
    }

    public function addNetletMapping($name, $urlPattern) {
        $this->netletMapping[$name][] = $urlPattern;
    }

    public function addFilter($name, $filterClass) {
        $this->filters[$name] = $filterClass;
    }

    public function addFilterMapping($name, $urlPattern) {
        $this->filterMapping[$name][] = $urlPattern;
    }

    public function addListener($name, $listenerClass) {
        $this->listeners[$name] = $listenerClass;
    }

    public function getAttribute($name) {
        if(!array_key_exists($name, $this->attributes))
                return null;
        return $this->attributes[$name];
    }

    public function getInitParameter($name, $postType = null) {
        if(!array_key_exists($name, $this->initParams))
                return null;
        return $this->initParams[$name];
    }

    public function getInitParameterMap() {
        return $this->initParams;
    }

    public function removeAttribute($name) {
        unset($this->attributes[$name]);
    }

    public function setAttribute($name, $o) {
        $this->attributes[$name] = $o;
    }

}
?>
