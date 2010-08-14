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
class EmptyOperation extends SimpleOperation{
    public function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets) {
        $val = $this->resolveSubParts($context, $subExpressions, $subBrackets, $this->expression);
        return $val == '';
    }

}



?>
