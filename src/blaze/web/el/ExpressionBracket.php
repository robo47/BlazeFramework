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
class ExpressionBracket extends Object{
	/**
	 * Contains all subbrackets
	 */
	private $expressionParts = array();
	/**
	 * expression String in the form:
	 * myNut.bla * (1) == {2}
	 *
	 * subbrackets get replaced with the placeholders (number) and number is the index of the elements in expressionParts
	 */
	private $expressionString;

        private $subExpressions;

	private $expressionOperation;

	public function __construct($bracketParts, $subExpressions){//, $expressionParts, $bracktes){
                $this->subExpressions = $subExpressions;
		if($bracketParts != null && is_array($bracketParts) && count($bracketParts) != 0){
			for($i = 0; $i < count($bracketParts); $i++){
				if(is_array($bracketParts[$i])){
					$this->expressionParts[] = new ExpressionBracket($bracketParts[$i], $subExpressions);
					$this->expressionString .= '('.$i.')';
				}else{
					$this->expressionParts[] = $bracketParts[$i];
					$this->expressionString .= $bracketParts[$i];
				}
			}

			$this->expressionOperation = new ExpressionOperation($this->expressionString);
		}
	}

	public function getExpressionOperation(){
		return $this->expressionOperation;
	}

        public function getValue(\blaze\web\application\BlazeContext $context){
            return $this->expressionOperation->getValue($context, $this->expressionParts, $this->subExpressions);
        }
}

?>
