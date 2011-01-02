<?php
namespace blaze\web\el\operation;
use blaze\lang\Object;

/**
 * Description of ELContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SimpleOperation extends BaseOperation{
	protected $expression;

	public function __construct($expression){
		$this->expression = $expression;
	}
        
        public function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets) {
            return $this->getValueFromExpression($context, $subExpressions, $subBrackets, $this->expression);
        }

}


?>
