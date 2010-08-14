<?php
namespace blaze\web\el\operation;
use blaze\lang\Object;

/**
 * Description of LowerOrEqualOperation
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class LowerOrEqualOperation extends ComplexOperation{
    public function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets) {
        $left = $this->getLeftOperation()->getValue($context, $subExpressions, $subBrackets);
        $right = $this->getRightOperation()->getValue($context, $subExpressions, $subBrackets);
        return $left <= $right;
    }
}



?>
