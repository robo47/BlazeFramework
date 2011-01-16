<?php

namespace blaze\web\el\scope;

use blaze\lang\Object,
 blaze\util\Map;

/**
 * Description of ELScopeContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ELViewScopeContext extends ELScopeContext {

    public function __construct(\blaze\collections\Map $nutDefinitions) {
        $this->nutDefinitions = $nutDefinitions;
    }

    private function getViewMap(\blaze\web\application\BlazeContext $context) {
        $sess = $context->getRequest()->getSession(true);
        $viewScope = 'blaze.web.el.scope.view';
        $viewMap = $sess->getAttribute($viewScope);

        if ($viewMap == null)
            $sess->setAttribute($viewScope, $viewMap = new \blaze\collections\map\HashMap());

        return $viewMap;
    }

    public function get(\blaze\web\application\BlazeContext $context, $key) {
        $defVal = $this->nutDefinitions->get($key);
        if ($defVal === null)
            return null;

        $viewMap = $this->getViewMap($context);
        $val = $viewMap->get($key);

        if ($val == null) {
            $val = \blaze\lang\ClassWrapper::forName($defVal)->newInstance();
            $viewMap->set($key, $val);
        }

        return $val;
    }

    public function set(\blaze\web\application\BlazeContext $context, $key, $val) {
        $viewMap = $this->getViewMap($context);
        $viewMap->set($key, $value);
    }

    public function resetValues(\blaze\web\application\BlazeContext $context) {
        $sess = $context->getRequest()->getSession(true);
        $sess->setAttribute('blaze.web.el.scope.view', null);
    }

}

?>
