<?php

namespace blaze\ds\driver\pdobase\meta;

use blaze\lang\Object,
 blaze\ds\meta\ColumnMetaData;

/**
 * Description of AbstractColumnMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class AbstractColumnMetaData extends Object implements ColumnMetaData {

    /**
     *
     * @var blaze\lang\String
     */
    protected $name;
    /**
     *
     * @var blaze\lang\String
     */
    protected $nativeType;
    /**
     *
     * @var blaze\lang\String
     */
    protected $classType;
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
    protected $autoIncrement;
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
    /**
     *
     * @var blaze\ds\meta\TableMetaData
     */
    protected $table;

    public function getName() {
        return $this->name;
    }

    public function getNativeType() {
        return $this->nativeType;
    }

    public function getClassType() {
        return $this->classType;
    }

    public function getLength() {
        return $this->length;
    }

    public function getPrecision() {
        return $this->precision;
    }

    public function getDefault() {
        return $this->default;
    }

    public function getComment() {
        return $this->comment;
    }

    public function isNullable() {
        return $this->nullable;
    }

    public function isAutoIncrement() {
        return $this->autoIncrement;
    }

    public function isSigned() {
        return $this->signed;
    }

    public function isPrimaryKey() {
        return $this->primaryKey;
    }

    public function isForeignKey() {
        return $this->foreignKey;
    }

    public function isUniqueKey() {
        return $this->uniqueKey;
    }

    public function getTable() {
        return $this->table;
    }

}

?>
