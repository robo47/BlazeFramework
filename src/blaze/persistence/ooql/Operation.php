<?php
namespace blaze\persistence\ooql;
use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Operation extends Object implements Argument, Operationable, Conditionable{
    
    const OP_PLUS = '+';
    const OP_MINUS = '-';
    const OP_DIVIDE = '/';
    const OP_MULTIPLY = '*';
    const OP_MODULO = '%';
    const OP_MINUS = '-';

    private $left;
    private $right;
    private $operation;

    public function __construct(Operationable $left, Operationable $right, $operation) {
        $this->left = $left;
        $this->right = $right;
        $this->operation = $operation;
    }

    public function getLeft() {
        return $this->left;
    }

    public function getRight() {
        return $this->right;
    }

    public function getOperation() {
        return $this->operation;
    }


}

?>
