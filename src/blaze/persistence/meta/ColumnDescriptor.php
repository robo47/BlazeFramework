<?php

namespace blaze\persistence\meta;

/**
 * Description of ColumnDescriptor
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ColumnDescriptor extends \blaze\lang\Object {
/**
     *
     * @var blaze\lang\String
     */
    protected $name;
    /**
     *
     * @var blaze\lang\String
     */
    protected $typeName;
    /**
     *
     * @var blaze\lang\String
     */
    protected $className;
    /**
     *
     * @var int
     */
    protected $length;
    /**
     *
     * @var int
     */
    protected $precision;
    /**
     *
     * @var blaze\lang\String
     */
    protected $default;
    /**
     *
     * @var blaze\lang\String
     */
    protected $comment;
    /**
     *
     * @var boolean
     */
    protected $nullable;
    /**
     *
     * @var boolean
     */
    protected $signed;
    /**
     *
     * @var boolean
     */
    protected $primaryKey;
    /**
     *
     * @var boolean
     */
    protected $foreignKey;
    /**
     *
     * @var boolean
     */
    protected $uniqueKey;

    public function __construct() {
        
    }

    public function apply(\blaze\ds\meta\ColumnMetaData $meta){
        $this->name = $meta->getName();
        $this->className = $meta->getClassType();
        $this->comment = $meta->getComment();
        $this->default = $meta->getDefault();
        $this->length = $meta->getLength();
        $this->precision = $meta->getPrecision();
        $this->foreignKey = $meta->isForeignKey();
        $this->primaryKey = $meta->isPrimaryKey();
        $this->uniqueKey = $meta->isUniqueKey();
        $this->nullable = $meta->isNullable();
        $this->signed = $meta->isSigned();
    }

    /**
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Native database types like varchar etc.
     *
     * @return blaze\lang\String
     */
    public function getTypeName() {
        return $this->typeName;
    }

    /**
     * PHP datatypes of the columns
     *
     * @return blaze\lang\String
     */
    public function getClassName() {
        return $this->className;
    }

    /**
     * @return int
     */
    public function getLength() {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getPrecision() {
        return $this->precision;
    }

    /**
     * @return blaze\lang\String
     */
    public function getDefault() {
        return $this->default;
    }

    /**
     * @return blaze\lang\String
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @return boolean
     */
    public function isNullable() {
        return $this->nullable;
    }

    /**
     * @return boolean
     */
    public function isSigned() {
        return $this->signed;
    }

    /**
     * @return boolean
     */
    public function isPrimaryKey() {
        return $this->primaryKey;
    }

    /**
     * @return boolean
     */
    public function isForeignKey() {
        return $this->foreignKey;
    }

    /**
     * @return boolean
     */
    public function isUniqueKey() {
        return $this->uniqueKey;
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
     * @param string|blaze\lang\String $typeName
     */
    public function setTypeName($typeName) {
        $this->typeName = \blaze\lang\String::asWrapper($typeName);
    }

    /**
     *
     * @param string|blaze\lang\String $className
     */
    public function setClassName($className) {
        $this->className = \blaze\lang\String::asWrapper($className);
    }

    /**
     *
     * @param int $length
     */
    public function setLength($length) {
        $this->length = $length;
    }

    /**
     *
     * @param int $precision
     */
    public function setPrecision($precision) {
        $this->precision = $precision;
    }

    /**
     *
     * @param mixed $default
     */
    public function setDefault($default) {
        $this->default = $default;
    }

    /**
     *
     * @param string|blaze\lang\String $comment
     */
    public function setComment($comment) {
        $this->comment = \blaze\lang\String::asWrapper($comment);
    }

    /**
     *
     * @param boolean $nullable
     */
    public function setNullable($nullable) {
        $this->nullable = $nullable;
    }

    /**
     *
     * @param boolean $signed
     */
    public function setSigned($signed) {
        $this->signed = $signed;
    }

    /**
     *
     * @param boolean $primaryKey
     */
    public function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }

    /**
     *
     * @param boolean $foreignKey
     */
    public function setForeignKey($foreignKey) {
        $this->foreignKey = $foreignKey;
    }

    /**
     *
     * @param boolean $uniqueKey
     */
    public function setUniqueKey($uniqueKey) {
        $this->uniqueKey = $uniqueKey;
    }

    public function toString(){
        return $this->name;
    }

}

?>
