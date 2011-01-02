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
class NoOperation extends SimpleOperation {

    private $isString;

    public function __construct($expression) {
        $this->expression = $expression;
        $this->isString = preg_match('/^"[^"\\\\\r\n]*(?:\\\\.[^"\\\\\r\n]*)*"$/', $this->expression) == 1 ||
                          preg_match('/^\'[^\'\\\\\r\n]*(?:\\\\.[^\'\\\\\r\n]*)*\'$/', $this->expression) == 1;
    }

    public function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets) {
        if ($this->isString)
            return substr($this->expression, 1, strlen($this->expression) - 2);
        else
            return $this->getValueFromExpression($context, $subExpressions, $subBrackets, $this->expression);
    }

    public function setValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets, $value) {
        $resolved = $this->resolveSubParts($context, $subExpressions, $subBrackets, $this->expression);
        $context->getELContext()->getELResolver()->setValue($resolved, $value);
    }

    public function invoke(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets, $values) {
        $resolved = $this->resolveSubParts($context, $subExpressions, $subBrackets, $this->expression);
        return $context->getELContext()->getELResolver()->invoke($resolved, $values);
    }

}
?>
