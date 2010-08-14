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
abstract class ELScopeContext extends Object{
    protected $nutDefinitions = array();

    /**
     * @return array
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
