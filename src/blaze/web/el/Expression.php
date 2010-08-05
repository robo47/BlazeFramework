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
        $this->expressionString = \blaze\lang\String::asWrapper($expressionString);
        $this->valid = self::isExpression($this->expressionString);
        if ($this->valid)
            $this->splitExpressionString();
    }

    public static function create($expressionString){
        return new Expression($expressionString);
    }

    protected function splitExpressionString() {
        $start = 0;
        $lastEnd = $this->expressionString->indexOf('}');
        $lastStart = $this->expressionString->indexOf('{');

        while ($lastStart != -1 && $lastEnd != -1) {
            $lastStart = $this->expressionString->indexOf('{', $lastStart + 1);

            if ($lastStart > $lastEnd) {
                $firstStart = $this->expressionString->indexOf('{', $start);
                $this->expressionParts[] = $this->expressionString->substring($start, $firstStart);
                $this->expressionParts[] = $this->expressionString->substring($firstStart, $lastEnd + 1);
                $start = $lastEnd + 1;
                $lastEnd = $this->expressionString->indexOf('}', $lastEnd + 1);
            } else {
                if ($this->expressionString->lastIndexOf('}') == $lastEnd) {
                    $firstStart = $this->expressionString->indexOf('{', $start);
                    
                    if ($start != $firstStart)
                        $this->expressionParts[] = $this->expressionString->substring($start, $firstStart);

                    $this->expressionParts[] = $this->expressionString->substring($firstStart, $lastEnd + 1);

                    if ($lastEnd + 1 != $this->expressionString->length())
                        $this->expressionParts[] = $this->expressionString->substring($lastEnd + 1, $this->expressionString->length());
                }else
                    $lastEnd = $this->expressionString->indexOf('}', $lastEnd + 1);
            }
        }
    }


    /**
     *
     * @return blaze\lang\String
     */
    public function getExpressionString() {
        return $this->expressionString;
    }

    /**
     *
     * @return array
     */
    public function getExpressionParts() {
        return $this->expressionParts;
    }

    public static function isExpression($expr) {
        $expr = \blaze\lang\String::asWrapper($expr);
        return $expr->matches('/{.*}/');
    }

    public function isValid() {
        return $this->valid;
    }

}
?>
