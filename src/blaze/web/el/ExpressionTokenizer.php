<?php
namespace blaze\web\el;
use blaze\lang\Object,
 blaze\tokenizer\BalancedTokenizer;

/**
 * Description of ELContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ExpressionTokenizer extends Object implements BalancedTokenizer{

	private $regex;
	private $openToken;
	private $openTokenLen;
	private $closeToken;
	private $closeTokenLen;

	public function __construct($openToken, $closeToken){
		$this->openToken = $openToken;
		$this->openTokenLen = strlen($openToken);
		$this->closeToken = $closeToken;
		$this->closeTokenLen = strlen($closeToken);

		$tokenComb = $openToken.$closeToken;
		$this->regex =  '/'.
						'(?:'.							// Begin recursion group
						'(?:\\'.$openToken.				// Opening token
						'(?:'.							// Possessive subgroup
							'(?: [^'.$tokenComb.']+ )'.	//  Get chars which or not the token
						'|'.							//    or
							'(?R)'.						//  Recurse
						')*'.							// Zero or more times
						'\\'.$closeToken.')'.			// Closing token
						'|'.							//  or
						'[^'.$tokenComb.']+'.			// Chars outside of the expression
						')'.							// End recursion group
						'/';
	}

	public function getOpenToken(){
		return $this->openToken;
	}

	public function getCloseToken(){
		return $this->closeToken;
	}

	public function tokenize($string){
		$matches = array();
		preg_match_all($this->regex, $string, $matches, PREG_OFFSET_CAPTURE);
		$elements = array();
		$nextPos = 0;

		if(count($matches[0]) == 0)
			return null; // no match
		if($matches[0][0][1] != 0)
			return null; // illegal expression

		foreach ($matches[0] as $match) {
			if($nextPos != $match[1])
				return null; // illegal expression
			$nextPos += strlen($match[0]);
			if(preg_match('/^\\'.$this->openToken.'.*\\'.$this->closeToken.'$/', $match[0])) // is expression
				$elements[] = $this->tokenize(substr($match[0],$this->openTokenLen,strlen($match[0])-($this->closeTokenLen+1))); // new expression
			else
				$elements[] = $match[0];
		}

		if($nextPos != strlen($string))
			return null; // illegal expression
		return $elements;
	}
}

?>
