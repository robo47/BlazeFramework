<?php

namespace blaze\persistence\ooql\formula;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class AbsFormula extends \blaze\persistence\ooql\Formula {

    private $expression;

    public function __construct($expression) {
        $this->expression = $expression;
    }

    public function getReturnType() {
        return 'int';
    }

}

?>
