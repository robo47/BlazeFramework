<?php

namespace blaze\web\el;

use blaze\lang\Object;

/**
 * Description of Expression
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ExpressionContent extends Object {

    /**
     * Contains all subexpressions
     */
    private $contentParts = array();
    /**
     * expression String in the form:
     * myNut.bla{1}.any == {2}
     *
     * subexpressions get replaced with the placeholders {number} and number is the index of the elements in contentParts
     */
    private $contentString;
    /**
     * If any brackets are in the content, this array contains the brackets as ExpressionBracket objects and Strings.
     */
    private $bracketParts = array();
    /**
     * expression String in the form:
     * myNut.bla * (1) == {2}
     *
     * brackets get replaced with the placeholders (number) and number is the index of the elements in bracketParts
     */
    private $bracketString;
    private $expressionOperation;



    public function __construct($expressionParts) {
        if ($expressionParts != null && is_array($expressionParts) && count($expressionParts) != 0) {
            for ($i = 0; $i < count($expressionParts); $i++) {
                if (is_array($expressionParts[$i])) {
                    $this->contentParts[] = new ExpressionContent($expressionParts[$i]);
                    $this->contentString .= '{' . $i . '}';
                } else {
                    $this->contentParts[] = $expressionParts[$i];
                    $this->contentString .= $expressionParts[$i];
                }
            }

            $this->parseBrackets();
            $this->expressionOperation = new ExpressionOperation($this->bracketString);
            //$this->expressionBracket = new ExpressionBracket($this->operationString, $this->operationParts);
            //$this->parse($this->operationString);
        }
    }

    private function parseBrackets() {
        $tokenizer = new ExpressionTokenizer('(', ')');
        $tokens = $tokenizer->tokenize($this->contentString);

        if ($tokens != null) {
            for ($i = 0; $i < count($tokens); $i++) {
                if (is_array($tokens[$i])) {
                    $this->bracketParts[] = new ExpressionBracket($tokens[$i], $this->contentParts); //, $this->operationParts);
                    $this->bracketString .= '(' . $i . ')';
                } else {
                    $this->bracketParts[] = $tokens[$i];
                    $this->bracketString .= $tokens[$i];
                }
            }
        }
    }

    public function getExpressionOperation() {
        return $this->expressionOperation;
    }

    public function getValue(\blaze\web\application\BlazeContext $context) {
        return $this->expressionOperation->getValue($context, $this->contentParts, $this->bracketParts);
    }

    public function setValue(\blaze\web\application\BlazeContext $context, $value) {
        if (count($this->bracketParts) != 1)
            throw new Exception('Invalid Expression for value bindings');

        $this->expressionOperation->setValue($context, $this->contentParts, $this->bracketParts, $value);
    }

    public function invoke(\blaze\web\application\BlazeContext $context, $values) {
        if (count($this->bracketParts) != 1)
            throw new Exception('Invalid Expression for method bindings');

        return $this->expressionOperation->invoke($context, $this->contentParts, $this->bracketParts, $values);
    }

}

?>
