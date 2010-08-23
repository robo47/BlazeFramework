<?php

namespace blaze\web\el\scope;

use blaze\lang\Object,
 blaze\util\Map;

/**
 * Description of ELScopeContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ELSessionScopeContext extends ELScopeContext {

    public function __construct($nutDefinitions) {
        $this->nutDefinitions = $nutDefinitions;
    }

    private function getSession(\blaze\web\application\BlazeContext $context) {
        return $context->getRequest()->getSession(true);
    }

    public function get(\blaze\web\application\BlazeContext $context, $key) {
        if (!array_key_exists($key, $this->nutDefinitions))
            return null;

        $sess = $this->getSession($context);
        $sess->getAttribute($key);
        $val = $this->getSession($context)->getAttribute($key);

        if ($val == null) {
            $val = $this->nutDefinitions[$key]->newInstance();
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
