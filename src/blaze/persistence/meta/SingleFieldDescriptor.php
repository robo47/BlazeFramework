<?php

namespace blaze\persistence\meta;

/**
 * Description of PropertyDescriptor
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SingleFieldDescriptor extends \blaze\lang\Object {

    /**
     *
     * @var blaze\lang\String
     */
    protected $name;
    /**
     *
     * @var blaze\lang\String
     */
    protected $type;
    /**
     *
     * @var blaze\persistence\meta\ColumnDescriptor
     */
    protected $columnDescriptor;

    public function __construct() {
        
    }

    /**
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->name;
    }

    /**
     * The type of the property
     *
     * @return blaze\lang\String
     */
    public function getType() {
        return $this->type;
    }

    /**
     * The column descriptor for this property
     *
     * @return blaze\persistence\meta\ColumnDescriptor
     */
    public function getColumnDescriptor() {
        return $this->columnDescriptor;
    }

    /**
     *
     * @param string|blaze\lang\String $name
     */
    public function setName($name) {
        $this->name = \blaze\lang\String::asWrapper($name);
    }

    /**
     *
     * @param string|blaze\lang\String $type
     */
    public function setType($type) {
        $this->type = \blaze\lang\String::asWrapper($type);
    }

    /**
     *
     * @param \blaze\persistence\meta\ColumnDescriptor $columnDescriptor 
     */
    public function setColumnDescriptor(\blaze\persistence\meta\ColumnDescriptor $columnDescriptor) {
        $this->columnDescriptor = $columnDescriptor;
    }

    public function generate(\blaze\lang\StringBuffer $buffer) {
        $buffer->append("\t" . '/**' . PHP_EOL);
        $buffer->append("\t" . ' * @var ' . $this->type . PHP_EOL);
        $buffer->append("\t" . ' */' . PHP_EOL);
        $buffer->append("\t" . 'private $');
        $buffer->append($this->name);
        $buffer->append(';' . PHP_EOL . PHP_EOL);
        $buffer->append("\t" . '/**' . PHP_EOL);
        $buffer->append("\t" . ' * @return ' . $this->type . PHP_EOL);
        $buffer->append("\t" . ' */' . PHP_EOL);
        $buffer->append("\t" . 'public function get' . $this->name->toUpperCase(true)->toNative() . '(){' . PHP_EOL);
        $buffer->append("\t" . "\t" . ' return $this->' . $this->name . ';' . PHP_EOL);
        $buffer->append("\t" . '}' . PHP_EOL . PHP_EOL);
        $buffer->append("\t" . '/**' . PHP_EOL);
        $buffer->append("\t" . ' * @param ' . $this->type . ' $' . $this->name . PHP_EOL);
        $buffer->append("\t" . ' */' . PHP_EOL);
        $buffer->append("\t" . 'public function set' . $this->name->toUpperCase(true)->toNative() . '($' . $this->name . '){' . PHP_EOL);
        $buffer->append("\t" . "\t" . ' $this->' . $this->name . ' = $' . $this->name . ';' . PHP_EOL);
        $buffer->append("\t" . '}' . PHP_EOL . PHP_EOL);
    }

}

?>
