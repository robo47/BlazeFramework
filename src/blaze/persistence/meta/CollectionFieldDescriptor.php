<?php

namespace blaze\persistence\meta;

/**
 * Description of PropertyDescriptor
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class CollectionFieldDescriptor extends \blaze\lang\Object {
    /**
     *
     * @var blaze\persistence\meta\SingleFieldDescriptor
     */
    protected $fieldDescriptor;
    /**
     *
     * @var blaze\persistence\meta\TableDescriptor
     */
    protected $tableDescriptor;
    /**
     *
     * @var blaze\persistence\meta\ColumnDescriptor
     */
    protected $columnDescriptor;
    /**
     *
     * @var blaze\persistence\meta\ClassDescriptor
     */
    protected $classDescriptor;
    /**
     *
     * @var blaze\persistence\meta\ColumnDescriptor
     */
    protected $junctionColumnDescriptor;

    public function __construct() {
        
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
     * @param \blaze\persistence\meta\SingleFieldDescriptor $fieldDescriptor
     */
    public function setFieldDescriptor(\blaze\persistence\meta\SingleFieldDescriptor $fieldDescriptor) {
        $this->fieldDescriptor = $fieldDescriptor;
    }

    /**
     *
     * @return \blaze\persistence\meta\ClassDescriptor
     */
    public function getClassDescriptor() {
        return $this->classDescriptor;
    }

    /**
     *
     * @param \blaze\persistence\meta\ClassDescriptor $classDescriptor
     */
    public function setClassDescriptor(\blaze\persistence\meta\ClassDescriptor $classDescriptor) {
        $this->classDescriptor = $classDescriptor;
    }

    /**
     *
     * @return \blaze\persistence\meta\TableDescriptor
     */
    public function getTableDescriptor() {
        return $this->tableDescriptor;
    }

    public function setTableDescriptor(\blaze\persistence\meta\TableDescriptor $tableDescriptor) {
        $this->tableDescriptor = $tableDescriptor;
    }

    /**
     *
     * @return \blaze\persistence\meta\ColumnDescriptor
     */
    public function getColumnDescriptor() {
        return $this->columnDescriptor;
    }

    public function setColumnDescriptor(\blaze\persistence\meta\ColumnDescriptor $columnDescriptor) {
        $this->columnDescriptor = $columnDescriptor;
    }

    /**
     *
     * @return \blaze\persistence\meta\ColumnDescriptor
     */
    public function getJunctionColumnDescriptor() {
        return $this->junctionColumnDescriptor;
    }

    public function setJunctionColumnDescriptor(\blaze\persistence\meta\ColumnDescriptor $junctionColumnDescriptor) {
        $this->junctionColumnDescriptor = $junctionColumnDescriptor;
    }

    public function generate(\blaze\lang\StringBuffer $buffer){
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @var blaze\\collections\\Set['.$this->classDescriptor->getFullName().']'.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'private $');
        $buffer->append($this->fieldDescriptor->getName());
        $buffer->append(';'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @return blaze\\collections\\Set['.$this->classDescriptor->getFullName().']'.PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function get'.$this->fieldDescriptor->getName()->toUpperCase(true)->toNative().'(){'.PHP_EOL);
        $buffer->append("\t"."\t".' return $this->'.$this->fieldDescriptor->getName().';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
        $buffer->append("\t".'/**'.PHP_EOL);
        $buffer->append("\t".' * @param blaze\\collections\\Set['.$this->classDescriptor->getFullName().'] $'.$this->fieldDescriptor->getName().PHP_EOL);
        $buffer->append("\t".' */'.PHP_EOL);
        $buffer->append("\t".'public function set'.$this->fieldDescriptor->getName()->toUpperCase(true)->toNative().'($'.$this->fieldDescriptor->getName().'){'.PHP_EOL);
        $buffer->append("\t"."\t".' $this->'.$this->fieldDescriptor->getName().' = $'.$this->fieldDescriptor->getName().';'.PHP_EOL);
        $buffer->append("\t".'}'.PHP_EOL.PHP_EOL);
    }

}

?>
