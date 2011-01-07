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
class EmptyOperation extends SimpleOperation {

    public function getValue(\blaze\web\application\BlazeContext $context, $subExpressions, $subBrackets) {
        $val = $this->resolveSubParts($context, $subExpressions, $subBrackets, $this->expression);
        return $val == '';
    }

}

?>
