<?php
namespace blaze\persistence\ooql\formula;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ConcatFormula extends \blaze\persistence\ooql\Formula{
    private $expression1;
    private $expression2;

    public function __construct($expression1, $expression2) {
        $this->expression1 = $expression1;
        $this->expression2 = $expression2;
    }

    public function getReturnType() {
        return 'blaze\\lang\\String';
    }

}

?>
