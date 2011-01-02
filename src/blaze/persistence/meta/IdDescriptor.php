<?php

namespace blaze\persistence\meta;

/**
 * Description of FieldDescriptor
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class IdDescriptor extends \blaze\lang\Object {
/**
     *
     * @var blaze\lang\String
     */
    protected $generatorName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $generatorType;
    /**
     *
     * @var blaze\persistence\meta\PropertyDescriptor
     */
    protected $fieldDescriptor;

    public function __construct() {
        
    }

    /**
     * @return blaze\lang\String
     */
    public function getGeneratorName() {
        return $this->generatorName;
    }

    /**
     * Native database types like varchar etc.
     *
     * @return blaze\lang\String
     */
    public function getGeneratorType() {
        return $this->generatorType;
    }

    /**
     * The column descriptor for this property
     *
     * @return blaze\persistence\meta\SingleFieldDescriptor
     */
    public function getFieldDescriptor() {
        return $this->fieldDescriptor;
    }

    /**
     *
     * @param string|blaze\lang\String $name
     */
    public function setGeneratorName($generatorName) {
        $this->generatorName = $generatorName;
    }

    /**
     *
     * @param string|blaze\lang\String $type
     */
    public function setGeneratorType($generatorType) {
        $this->generatorType = $generatorType;
    }

    /**
     *
     * @param \blaze\persistence\meta\SingleFieldDescriptor $fieldDescriptor
     */
    public function setSingleFieldDescriptor(\blaze\persistence\meta\SingleFieldDescriptor $fieldDescriptor) {
        $this->fieldDescriptor = $fieldDescriptor;
    }

    public function generate(\blaze\lang\StringBuffer $buffer){
        $this->fieldDescriptor->generate($buffer);
    }
}

?>
