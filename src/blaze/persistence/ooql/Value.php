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
class Value extends Object implements Argument, Conditionable, Operationable{

    const TYPE_STRING = 0;
    const TYPE_SCALAR = 1;

    private $negation;
    private $value;
    private $valueType;

    public function __construct($value, $valueType = self::TYPE_STRING, $negation = false) {
        $this->value = $value;
        $this->valueType = $valueType;
        $this->negation = $negation;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getValueType() {
        return $this->valueType;
    }

    public function setValueType($valueType) {
        $this->valueType = $valueType;
    }

}

?>
