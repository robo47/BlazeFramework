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
class ELSessionScopeContext extends ELScopeContext {

    public function __construct(\blaze\collections\Map $nutDefinitions) {
        $this->nutDefinitions = $nutDefinitions;
    }

    private function getSession(\blaze\web\application\BlazeContext $context) {
        return $context->getRequest()->getSession(true);
    }

    public function get(\blaze\web\application\BlazeContext $context, $key) {
        $defVal = $this->nutDefinitions->get($key);
        if ($defVal === null)
            return null;

        $sess = $this->getSession($context);
        $val = $sess->getAttribute($key);

        if ($val == null) {
            $val = \blaze\lang\ClassWrapper::forName($defVal)->newInstance();
            $this->getSession($context)->setAttribute($key, $val);
        }

        return $val;
    }

    public function set(\blaze\web\application\BlazeContext $context, $key, $val) {
        $this->getSession($context)->setAttribute($key, $val);
    }

    public function resetValues(\blaze\web\application\BlazeContext $context) {
        
    }

}

?>
