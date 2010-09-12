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
class ExpressionOperation extends Object {

    private $expressionString;
    private $operations = array();
    private $hasOperations = true;
    /**
     *
     * @var blaze\web\el\operation\BaseOperation
     */
    private $rootOperation;
    private $operatorLevels = array(array('empty'),
        array('!'),
        array('*', '/', '%'),
        array('+', '-'),
        array('<=', '<', '>=', '>'),
        array('==', '!='),
        array('&&'),
        array('||'));

    public function __construct($expressionString) {
        $this->expressionString = $expressionString;
        $tokenizer = new ExpressionOperationTokenizer();
        $operations = $tokenizer->tokenize($expressionString);

        if (count($operations) == 1) {
            $this->hasOperations = false;
            $this->parseFirstLevel(0, 0, $operations);

            // If no function was found, make a NoOperation object
            if (!isset($this->operations[0]) || $this->operations[0][0] == null) {
                if ($operations[0]['leftNegation'])
                    $this->rootOperation = new operation\NotOperation($operations[0]['leftExpression']);
                else
                    $this->rootOperation = new operation\NoOperation($operations[0]['leftExpression']);
            }else{
                $this->rootOperation = $this->operations[0][0];
            }
        }else {
            // Go through all operator levels, $i is the actual operator level
            for ($i = 0; $i < count($this->operatorLevels); $i++) {
                // For each operator level go to all operations, $j is the actual operation which was tokenized before
                for ($j = 0; $j < count($operations); $j++) {
                    if ($i == 0) { // Function level
                        $this->parseFirstLevel($i, $j, $operations);
                        
                        // If no function was found, make a NoOperation object
                        if (!isset($this->operations[$i][$j]) || $this->operations[$i][$j] == null)
                            $this->operations[$i][$j] = new operation\NoOperation($operations[$j]['leftExpression']);
                    }else if ($i == 1) { // Negation level
                        // If the negation is set, make a NotOperation object with the object from the parent level
                        if ($operations[$j]['leftNegation'])
                            $this->operations[$i][$j] = new operation\NotOperation($this->operations[$i - 1][$j]);
                        // If no negation is set, put the object from the parent level to the current
                        else
                            $this->operations[$i][$j] = $this->operations[$i - 1][$j];
                    }else { // Other levels
                        // If the operation fits to any of the operations of the current operation level
                        if (in_array($operations[$j]['operation'], $this->operatorLevels[$i])) {
                            // Make a new operation object with the objects from the parent level
                            $this->operations[$i][$j] = $this->getOperationObject($operations[$j]['operation'], $this->operations[$i - 1][$j], $this->operations[$i - 1][$j + 1]);
                            // Set the next obj of the current level to the new operation object, because an operation includes the current and the next object
                            $this->operations[$i][$j + 1] = $this->operations[$i][$j];

                            // get all objects from the parent level which are equal to the object of the parent level which was used to create an operation object.
                            // for every object which is equal to the one which was used, the objects in the current level are replaced by the new operation object.
                            for ($idx = $j - 1; $idx >= 0; $idx--)
                                if ($this->operations[$i - 1][$idx] == $this->operations[$i - 1][$j])
                                    $this->operations[$i][$idx] = $this->operations[$i][$j];
                        }else {
                            // Only do the pass from the parent level to the actual one, if no object was set in the current level
                            if (!isset($this->operations[$i][$j]) || $this->operations[$i][$j] == null)
                            // Get the objects from the parent level to the actual
                                $this->operations[$i][$j] = $this->operations[$i - 1][$j];
                        }
                    }
                }
            }
            $this->rootOperation = $this->operations[6][0];
        }
    }

    private function parseFirstLevel($i, $j, $operations){
        // Look through all functions
        foreach ($this->operatorLevels[$i] as $functionName) {
            $pos = stripos($operations[$j]['leftExpression'], $functionName);

            // If the expressionstring contains the function name
            if ($pos !== false) {
                $string = '';

                // Remove the function name
                if ($pos != 0)
                    $string = substr($operations[$j]['leftExpression'], 0, $pos);
                $string .= substr($operations[$j]['leftExpression'], $pos + strlen($functionName));
                // Make a new function object
                $this->operations[$i][$j] = $this->getFunctionObject($functionName, $string);
                // Break because there can only be one function
                break;
            }
        }
    }

    private function getOperationObject($operator, $left, $right) {
        switch ($operator) {
            case '*':
                return new operation\MultiplyOperation($left, $right);
            case '/':
                return new operation\DivideOperation($left, $right);
            case '%':
                return new operation\ModuloOperation($left, $right);
            case '+':
                return new operation\PlusOperation($left, $right);
            case '-':
                return new operation\MinusOperation($left, $right);
            case '<=':
                return new operation\LowerOrEqualOperation($left, $right);
            case '<':
                return new operation\LowerOperation($left, $right);
            case '>=':
                return new operation\GreaterOrEqualOperation($left, $right);
            case '>':
                return new operation\GreaterOperation($left, $right);
            case '==':
                return new operation\EqualsOperation($left, $right);
            case '!=':
                return new operation\EqualsNotOperation($left, $right);
            case '&&':
                return new operation\AndOperation($left, $right);
            case '||':
                return new operation\OrOperation($left, $right);
        }
    }

    private function getFunctionObject($functionName, $content) {
        switch ($functionName) {
            case 'empty':
                return new operation\EmptyOperation($content);
        }
    }

    public function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets) {
        return $this->rootOperation->getValue($context, $subExpressions, $subBrackets);
    }

    public function setValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets, $value) {
        if ($this->hasOperations || !$this->rootOperation instanceof operation\NoOperation)
            throw new Exception('Invalid Expression for value bindings');
        $this->rootOperation->setValue($context, $subExpressions, $subBrackets, $value);
    }

    public function invoke(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets, $values) {
        if ($this->hasOperations || !$this->rootOperation instanceof operation\NoOperation)
            throw new Exception('Invalid Expression for method bindings');
        return $this->rootOperation->invoke($context, $subExpressions, $subBrackets, $values);
    }

}
?>
