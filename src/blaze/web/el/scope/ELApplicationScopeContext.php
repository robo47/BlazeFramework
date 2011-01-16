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
class ELApplicationScopeContext extends ELScopeContext {

    private $variables;

    public function __construct(\blaze\collections\Map $nutDefinitions) {
        $this->nutDefinitions = $nutDefinitions;
        $this->variables = new \blaze\collections\map\HashMap();
    }

    public function get(\blaze\web\application\BlazeContext $context, $key) {
        $val = $this->variables->get($key);

        if ($val === null) {
            $def = $this->nutDefinitions->get($key);
            if ($def !== null) {
                $val = \blaze\lang\ClassWrapper::forName($def)->newInstance();
                $this->variables->put($key, $val);
            }
        }

        return $val;
    }

    public function set(\blaze\web\application\BlazeContext $context, $key, $val) {
        $this->variables->put($key, $val);
    }

    public function resetValues(\blaze\web\application\BlazeContext $context) {
        
    }

}

?>
