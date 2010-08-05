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
class Expression extends Object{
    protected $expressionString;
    protected $valid;

    public function __construct($expressionString) {
        $this->expressionString = \blaze\lang\String::asWrapper($expressionString);
        $this->valid = self::isExpression($this->expressionString);
        if($this->valid)
            $this->expressionString = $this->expressionString->substring(1, $this->expressionString->length()-1);
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getExpressionString() {
        return $this->expressionString;
    }

    public static function isExpression($expr){
        $expr = \blaze\lang\String::asWrapper($expr);
        return $expr->matches('/^{.*}$/');
    }

    public function isValid(){
        return $this->valid;
    }
}

?>
