<?php

namespace blaze\web\el;

use blaze\lang\Object;

/**
 * Description of Expression
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Expression extends Object {

    protected $expressionString;
    protected $valid;
    protected $expressionParts = array();

    public function __construct($expressionString) {
        $this->expressionString = $expressionString;//\blaze\lang\String::asWrapper($expressionString);
        $this->valid = self::isExpression($this->expressionString);

        if ($this->valid)
            $this->splitExpressionString();
    }

    public static function create($expressionString){
        return new Expression($expressionString);
    }

    protected function splitExpressionString() {
		$tokenizer = new ExpressionTokenizer('{','}');
        $tokens = $tokenizer->tokenize($this->expressionString);

		if($tokens != null){
			foreach($tokens as $token){
				if(is_array($token)){
					$this->expressionParts[] = new ExpressionContent($token);
				}else{
					$this->expressionParts[] = $token;
				}
			}
		}
    }

	public function getValue(\blaze\web\application\BlazeContext $context){
		$value = null;

		if(count($this->expressionParts) == 1){
			if($this->expressionParts[0] instanceof ExpressionContent)
				$value = $this->expressionParts[0]->getValue($context);
			else
				$value = $this->expressionParts[0];
		}else{
			$value = '';

			foreach($this->expressionParts as $part){
				if($part instanceof ExpressionContent)
					$value .= $part->getValue($context);
				else
					$value .= $part;
			}
		}

		return $value;
	}

	public function setValue(\blaze\web\application\BlazeContext $context, $value){
		if(count($this->expressionParts) != 1 ||
		   !($this->expressionParts[0] instanceof ExpressionContent))
		   throw new \blaze\lang\Exception('Invalid Expression for value bindings');

		$this->expressionParts[0]->setValue($context, $value);
	}

	public function invoke(\blaze\web\application\BlazeContext $context, $values){
		if(count($this->expressionParts) != 1 ||
		   !($this->expressionParts[0] instanceof ExpressionContent))
		   throw new \blaze\lang\Exception('Invalid Expression for method bindings');

		return $this->expressionParts[0]->invoke($context, $values);
	}

    /**
     *
     * @return blaze\lang\String
     */
    public function getExpressionString() {
        return $this->expressionString;
    }

    public static function isExpression($expr) {
        //$expr = \blaze\lang\String::asWrapper($expr);
        //return $expr->matches('/{.*}/');
		return preg_match('/{.*}/', $expr) != 0;
    }

    public function isValid() {
        return $this->valid;
    }

}
?>
