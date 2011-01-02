<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\ClassWrapper;

/**
 * Description of NavigationRule
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class NavigationRule extends Object {

    private $indexView;
    private $mapping;
    private $bindings;
    private $actions;

    public function __construct($indexView, $mapping, \blaze\collections\Map $actions = null, \blaze\collections\ListI $bindings = null) {
        $this->indexView = $indexView;
        $this->mapping = $mapping;
        $this->bindings = $bindings;
        $this->actions = $actions;
    }

    public function getIndexView() {
        return $this->indexView;
    }

    public function getMapping() {
        return $this->mapping;
    }

    public function getBindings() {
        return $this->bindings;
    }

    public function getActions() {
        return $this->actions;
    }

    public function addAction($action, $view){
        if($this->actions == null)
                $this->actions = new \blaze\collections\map\HashMap();
        $this->actions->put($action, $view);
    }

    public function addBinding($name, $reference, $default = null){
        if($this->bindings == null)
                $this->bindings = new \blaze\collections\lists\ArrayList();
        $this->actions->add(new Binding($name, $reference, $default));
    }

}

?>
