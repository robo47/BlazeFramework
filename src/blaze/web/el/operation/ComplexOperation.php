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
class ComplexOperation extends BaseOperation{
	private $leftOperation;
	private $rightOperation;

	public function __construct(BaseOperation $leftOperation, BaseOperation $rightOperation){
		$this->leftOperation = $leftOperation;
		$this->rightOperation = $rightOperation;
	}

        public function getLeftOperation() {
            return $this->leftOperation;
        }

        public function getRightOperation() {
            return $this->rightOperation;
        }

        public function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets) {

        }
}


?>
