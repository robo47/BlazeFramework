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
abstract class Formula extends Object implements Selectable, Argument, Operationable, Conditionable{

    private $alias;
    private $formulaName;
    private $arguments = array();

    public function __construct($alias = null) {
        $this->alias = $alias;
    }

    public function getFormulaName() {
        return $this->formulaName;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function getPrefix(){
        return null;
    }

    public function getType(){
        return self::FORMULA;
    }

    public abstract function getReturnType();

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

}

?>
