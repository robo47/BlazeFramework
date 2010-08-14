<?php
namespace blaze\web\el;
use blaze\lang\Object,
    blaze\util\Map,
    blaze\lang\NullPointerException;

/**
 * Description of ELResolver
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ELResolver extends Object{
    /**
     *
     * @var blaze\web\el\ELContext
     */
    protected $context;

    public function __construct(ELContext $context) {
        $this->context = $context;
    }

    private function resolveSubExpressions(\blaze\lang\String $exprString){
        $start = $exprString->indexOf('{');
        $end = $exprString->lastIndexOf('}')+1;

        $prependStr = $exprString->substring(0,$start);
        $appendStr = $exprString->substring($end);
        return \blaze\lang\String::asWrapper($prependStr.\blaze\lang\String::asNative($this->getValueByExpressionString($exprString->substring($start,$end))).$appendStr);
    }

    /**
     * Needs the string with beginning { and ending }
     * 
     * @param blaze\lang\String $exprString 
     */
    private function getValueByExpressionString(\blaze\lang\String $exprString){
        $expr = $exprString->substring(1,$exprString->length()-1);
        $start = $exprString->indexOf('{');
        $end = $exprString->lastIndexOf('}')+1;

        $beginStr = $exprString->substring(0,$start);
        $endStr = $exprString->substring($end);
        $subPart = $exprString->substring($start+1,$end-1);

        if(Expression::isExpression($subPart))
            $subPart = $this->resolveSubExpressions($subPart);
        $expr = new \blaze\lang\String($beginStr->toNative().$subPart->toNative().$endStr->toNative());

         return $this->resolveBrackets($expr);
    }
    
    private function resolveBrackets(\blaze\lang\String $expr){
        $emptyUse = false;
        $lastStart = $expr->lastIndexOf('(');
        if($lastStart != -1)
            $lastEnd = $expr->indexOf(')', $lastStart);
        else
            $lastEnd = -1;
        // Get the deepest nested expression
        // For example this: {asd.intVal * (asd.intVal2 + asd.intVal3)}

        //var_dump($expr->toNative());
        if($lastEnd == -1 && $lastStart != -1 ||
           $lastEnd != -1 && $lastStart == -1)
            throw new \blaze\lang\Exception('Maybe you forgot to close or open a bracket?');

        // Brackets properly used
        if($lastEnd != -1 && $lastStart != -1){
            $expression = $expr->substring($lastStart+1, $lastEnd);
            if($lastStart >= 5)
                $emptyUse = $expr->substring($lastStart-5, $lastStart+1)->equalsIgnoreCase('empty(');
        //No bracktes used
        }else{
            $expression = $expr;
        }
        
        $expression = $this->resolveExpression($expression);
        if($emptyUse){
            if($expression == null || ($expression instanceof \blaze\lang\String && $expression->length() == 0))
                    $expression = new \blaze\lang\String('true');
            else
                $expression = new \blaze\lang\String('false');
        }

        
        // If there were any brackets, put the whole string together again
        // and make a recursive call to look for more brackets
        if($emptyUse)
            $lastStart -= 5;
        if($lastEnd != -1 && $lastStart != -1){
            $tempExp = null;

            // Bracket open was not the first char
            if($lastStart != 0 )
                // put prefix and the resolved inner expression together
                $tempExp = $expr->substring(0, $lastStart).' '.$expression;
            // Bracket close was not the last char
            if($lastEnd != $expr->length()){
                // Bracket open was not the first char
                if($lastStart != 0)
                    // concate the suffix to the prefix+expression
                    $tempExp .= ' '.$expr->substring($lastEnd, $expr->length()-1);
                // Bracket open was the first char
                else
                    // only concate the suffix to the expression
                    $tempExp = $expression.$expr->substring($lastEnd, $expr->length()-1);
            }

            // Concatation happened
            if($tempExp != null)
                $expression = \blaze\lang\String::asWrapper($tempExp);
            // Can never be something else than a blaze\lang\String but we
            // do it to avoid errors
            if($expression instanceof \blaze\lang\String)
                $expression = $this->resolveBrackets($expression);
        }
        
        if($expression instanceof \blaze\lang\String){
//            if($expression->startsWith('"') && $expression->endsWith('"'))
//                return $expression->substring(1,$expression->length()-1);
//            else
                if($expression->matches('/[a-z]+[a-z0-9\\_\\-]*(\\.[a-z]+[a-z0-9\\_\\-]*)*/i')){
                return $this->getValueFromMapper($expression);
            }
        }
        
        return $expression;
    }

    /**
     * This method can accept expression in the following style
     * Operand1 Operator Operand2
     *
     * @param \blaze\lang\String $expression
     * @return <type>
     */
    private function resolveExpression(\blaze\lang\String $expression){
        // Prefix ! empty()
        //var_dump($expression);
        $occur = $expression->indexOf('!');
        $start = 0;
        $negated = '';
        while($occur != -1){
            if($expression->charAt($occur+1) == '='){
                    $occur = $expression->indexOf('!', $occur+1);
                    continue;
            }else{
                if($occur > 0)
                    $negated .= $expression->substring($start, $occur)->toNative();

                $exprEnd = $expression->indexOf(' ', $occur+1);
                $appendEnd = null;
                if($exprEnd == -1)
                    $exprEnd = $expression->length();
                $start = $exprEnd;
                $left = $expression->substring($occur+1, $exprEnd);
                if($left->matches('/[a-z]+[a-z0-9_]*(\\.[a-z]+[a-z0-9_]*)+/i'))
                    $left = $this->getValueFromMapper($left);
                if($left instanceof \blaze\lang\String){
                    if($left->matches('/".*"/'))
                            $left = $left->substring(1, $left->length()-1)->toNative();
                    else if($left->matches('/^(true|false)$/'))
                            $left = \blaze\lang\Boolean::parseBoolean($left->toNative());
                    else if($left->matches('/^null$/'))
                            $left = null;
                    else
                        $left = $left->toNative();
                }

                $negated .= !$left ? 'true' : 'false';
                if($appendEnd != null)
                    $negated .= $appendEnd;
                $occur = $expression->indexOf('!', $occur+1);
            }
        }
        if($negated != '')
            $expression = \blaze\lang\String::asWrapper($negated);
        // Arithmetic * / % + -
        // Relational < <= > >= == !=
        // Logical && ||
        $relationalOperators = array('*','/','%','+','-','<=','<', '>=', '>', '==', '!=','&&', '||');

        foreach($relationalOperators as $operator){
            $occur = $expression->indexOf($operator);

            // Operator was found in the expression
            if($occur != -1){
                var_dump($expression);
                $operatorLen = strlen($operator);

                // get the left side of the operator trimmed
                $left = $expression->substring(0, $occur)->trim();
                $leftEnd = $left->lastIndexOf(' ');
                if($leftEnd != -1)
                    $left = $left->substring(0, $leftEnd);

                // get the right side of the operator trimmed
                $right = $expression->substring($occur+$operatorLen)->trim(' ');
                $rightEnd = $right->indexOf(' ');
                if($rightEnd != -1)
                    $right = $right->substring(0, $rightEnd);

                $result = null;

                // Resolve the expression by getting a value from a map
                if($left->matches('/[a-z]+[a-z0-9_]*(\\.[a-z]+[a-z0-9_]*)+/i'))
                    $left = $this->getValueFromMapper($left);
                if($right->matches('/[a-z]+[a-z0-9_]*(\\.[a-z]+[a-z0-9_]*)+/i'))
                    $right = $this->getValueFromMapper($right);

                if($left instanceof \blaze\lang\String){
                    if($left->matches('/".*"/'))
                            $left = $left->substring(1, $left->length()-1)->toNative();
                    else if($left->matches('/^(true|false)$/'))
                            $left = \blaze\lang\Boolean::parseBoolean($left->toNative());
                    else if($left->matches('/^null$/'))
                            $left = null;
                    else
                        $left = $left->toNative();
                }
                if($right instanceof \blaze\lang\String){
                    if($right->matches('/".*"/'))
                            $right = $right->substring(1, $right->length()-1)->toNative();
                    else if($right->matches('/^(true|false)$/'))
                            $right = \blaze\lang\Boolean::parseBoolean($right->toNative());
                    else if($right->matches('/^null$/'))
                            $right = null;
                    else
                        $right = $right->toNative();
                }
                
                switch($operator){
                    case '*':
                        $result = $left * $right;
                        break;
                    case '/':
                        $result = $left / $right;
                        break;
                    case '%':
                        $result = $left % $right;
                        break;
                    case '+':
                        $result = $left + $right;
                        break;
                    case '-':
                        $result = $left - $right;
                        break;
                    case '<=':
                        $result = $left <= $right;
                        break;
                    case '<':
                        $result = $left < $right;
                        break;
                    case '>=':
                        $result = $left >= $right;
                        break;
                    case '>':
                        $result = $left > $right;
                        break;
                    case '==':
                        $result = $left == $right;
                        break;
                    case '!=':
                        $result = $left != $right;
                        break;
                    case '&&':
                        $result = $left && $right;
                        break;
                    case '||':
                        $result = $left || $right;
                        break;
                }

                $expression = $result;
                break;
            }
        }
        
        if(\blaze\lang\String::asWrapper($expression)->matches('/^(true|false)$/'))
             return \blaze\lang\Boolean::parseBoolean($expression);
        else
            return $expression;
    }

    private function getValueFromMapper(\blaze\lang\String $expr){
        $parts = $expr->split('.',null,true);
        $partsCount = count($parts);

        if($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->context->getVariableMapper()->get($parts[0]);

        if($obj == null)
            throw new ELException($parts[0].' is not a valid expression object');

        for($i = 1; $i < $partsCount; $i++){
            if($obj == null)
                throw new NullPointerException($parts[$i-1].' is null');
            $method = $obj->getClass()->getMethod('get'.$parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        return $obj;
    }

    private function getValueFromContext($key){
        $ctx = \blaze\web\application\BlazeContext::getCurrentInstance();
        $key = \blaze\lang\String::asNative($key);

        $val = $this->context->getContext(ELContext::SCOPE_REQUEST)->get($ctx, $key);
        if($val != null)
            return $val;
        $val = $this->context->getContext(ELContext::SCOPE_VIEW)->get($ctx, $key);
        if($val != null)
            return $val;
        $val = $this->context->getContext(ELContext::SCOPE_SESSION)->get($ctx, $key);
        if($val != null)
            return $val;
        $val = $this->context->getContext(ELContext::SCOPE_APPLICATION)->get($ctx, $key);
        if($val != null)
            return $val;
        return null;
    }

    public function getValue($expr){
        $parts = \blaze\lang\String::asWrapper($expr)->split('.',null,true);
        $partsCount = count($parts);

        if($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->getValueFromContext($parts[0]);

        if($obj == null)
            throw new ELException($parts[0].' is not a valid expression object');

        for($i = 1; $i < $partsCount; $i++){
            if($obj == null)
                throw new NullPointerException($parts[$i-1].' is null');
            $method = $obj->getClass()->getMethod('get'.$parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        return $obj;
    }

    public function setValue(Expression $expr, $value){
        $str = $expr->getExpressionString();
        $parts = $str->split('.',null,true);
        $partsCount = count($parts);

        if($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->context->getVariableMapper()->get($parts[0]);

        if($obj == null)
            throw new ELException($parts[0].' is not a valid expression object');

        for($i = 1; $i < $partsCount - 1; $i++){
            $method = $obj->getClass()->getMethod('get'.$parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        $method = $obj->getClass()->getMethod('set'.$parts[$partsCount - 1]->toUpperCase(true));
        $method->invoke($obj, $value);
    }
    /**
     *
     * @param Expression $expr
     * @param array $values 
     */
    public function invoke(Expression $expr, $values){
        $str = $expr->getExpressionString();
        $parts = $str->split('.',null,true);
        $partsCount = count($parts);

        if($partsCount < 1)
            throw new ELException('No valid expression');

        $obj = $this->context->getVariableMapper()->get($parts[0]);

        if($obj == null)
            throw new ELException($parts[0].' is not a valid expression object');

        for($i = 1; $i < $partsCount - 1; $i++){
            $method = $obj->getClass()->getMethod('get'.$parts[$i]->toUpperCase(true));
            $obj = $method->invoke($obj, null);
        }

        $method = $obj->getClass()->getMethod($parts[$partsCount - 1]->toUpperCase(true));
        return $method->invoke($obj, $values);
    }
}

?>
