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
abstract class ELScopeContext extends Object{
    protected $nutDefinitions;

    /**
     * @return \blaze\collections\Map 
     */
    public function getDefinitions(){
            return $this->nutDefinitions;
    }

    /**
     *
     * @return blaze\lang\Object
     */
    public abstract function get(\blaze\web\application\BlazeContext $context, $key);
    public abstract function set(\blaze\web\application\BlazeContext $context, $key, $val);
    public abstract function resetValues(\blaze\web\application\BlazeContext $context);
}

?>
