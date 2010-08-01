<?php
namespace blaze\persistence\tool;
use blaze\lang\Object;

/**
 * Description of ColumnMetadata
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ColumnMetadata extends Object {
    /**
     *
     * @var string
     */
    private $name;
    /**
     *
     * @var string
     */
    private $type;
    /**
     *
     * @var integer
     */
    private $length;
    /**
     *
     * @var integer
     */
    private $decimals;
    /**
     *
     * @var boolean
     */
    private $nullable;
    /**
     *
     * @var array
     */
    private $constraints = array();

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
    
    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getDecimals() {
        return $this->decimals;
    }

    public function setDecimals($decimals) {
        $this->decimals = $decimals;
    }

    public function getNullable() {
        return $this->nullable;
    }

    public function setNullable($nullable) {
        $this->nullable = $nullable;
    }

    public function getConstraints() {
        return $this->constraints;
    }

    public function setConstraints($constraints) {
        $this->constraints = $constraints;
    }

    public function addConstraint(ConstraintMetadata $constraint){
        $this->constraints[] = $constraint;
    }
}

?>
