<?php
namespace blaze\web\el\operation;
use blaze\lang\Object;

/**
 * Description of ELContext
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class BaseOperation extends Object{

        public abstract function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets);
        protected function getValueFromExpression(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets, $expr){
            if($expr instanceof BaseOperation){
                $val = $expr->getValue($context, $subExpressions, $subBrackets);
            }else
                $val = $expr;

            $val = $this->resolveSubParts($context, $subExpressions, $subBrackets, $val);

            if(($class = \blaze\lang\Number::getNumberClass($val)) != null){
                return $class->getMethod('asNative')->invoke(null,$val);
            }else if(preg_match('/^(true|false)$/', $val))
                return \blaze\lang\Boolean::parseBoolean($val);
            else //if(strpos($val, '.') !== false)
                return $context->getELContext()->getELResolver()->getValue($val);
//            else
//                return $val;
        }
        protected function resolveSubParts(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets, $expressionString){
            if(\blaze\lang\String::isNativeType($expressionString)){
                while(preg_match('/\\{([0-9]*)\\}/', $expressionString, $matches) != 0){
                    $val = $subExpressions[\blaze\lang\Integer::asNative($matches[1])]->getValue($context);
                    $expressionString = str_replace($matches[0], $val, $expressionString);
                }
                while(preg_match('/\\(([0-9]*)\\)/', $expressionString, $matches) != 0){
                    $val = $subBrackets[\blaze\lang\Integer::asNative($matches[1])]->getValue($context);
                    $expressionString = str_replace($matches[0], $val, $expressionString);
                }
            }

            return $expressionString;
        }

}


?>
