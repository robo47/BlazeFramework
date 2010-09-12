<?php
namespace blaze\persistence\ooql;
use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Formula extends Object implements Selectable, Argument, Operationable, Conditionable{

    private $negation;
    private $formulaName;
    private $arguments = array();

    public function __construct($formulaName, $negation = false) {
        $this->formulaName = $formulaName;
        $this->negation = $negation;
    }

    public function addArgument(Argument $arg){
        $this->arguments[] = $arg;
    }

    public function getFormulaName() {
        return $this->formulaName;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function setFormulaName($formulaName) {
        $this->formulaName = $formulaName;
    }

    public function getNegation() {
        return $this->negation;
    }

    public function setNegation($negation) {
        $this->negation = $negation;
    }

}

?>
