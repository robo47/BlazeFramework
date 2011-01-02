<?php
namespace blaze\web\el;
use blaze\lang\Object,
    blaze\util\Map;

/**
 * Description of ELContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ELContext extends Object{

    const SCOPE_REQUEST = 0;
    const SCOPE_VIEW = 1;
    const SCOPE_SESSION = 2;
    const SCOPE_APPLICATION = 3;

    private $resolver;
    private $contexts = array();

    public function __construct() {
        $this->resolver = new ELResolver($this);
    }

    public function setContext($key, scope\ELScopeContext $context){
        $this->contexts[$key] = $context;
        return $this;
    }

    /**
     *
     * @param mixed $key
     * @return blaze\web\el\scope\ELScopeContext
     */
    public function getContext($key){
        if(array_key_exists($key, $this->contexts))
                return $this->contexts[$key];
        return null;
    }

    /**
     *
     * @return blaze\web\el\ELResolver
     */
    public function getELResolver() {
        return $this->resolver;
    }
}

?>
