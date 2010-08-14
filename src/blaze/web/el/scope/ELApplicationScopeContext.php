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
class ELApplicationScopeContext extends ELScopeContext{

	private $variables;

	public function __construct($nutDefinitions){
		$this->nutDefinitions = $nutDefinitions;
		$this->variables = $this->nutDefinitions;
	}

	public function get(\blaze\web\application\BlazeContext $context, $key){
		if(array_key_exists($key, $this->variables)){
			$val = $this->variables[$key];
			if($val instanceof \blaze\lang\ClassWrapper)
				$this->set($key, $val = $val->newInstance());

			return $val;
		}

		return null;
	}

	public function set(\blaze\web\application\BlazeContext $context, $key, $val){
		$this->variables[$key] = $val;
	}

	public function resetValues(\blaze\web\application\BlazeContext $context){
	}
}



?>
