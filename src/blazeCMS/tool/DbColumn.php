<?php
namespace blazeCMS\tool;
use blaze\lang\Object;

/**
 * Description of DbColumn
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class DbColumn extends Object {
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
    private $precision;
    /**
     *
     * @var integer
     */
    private $scale;
    /**
     *
     * @var boolean
     */
    private $nullable;
    /**
     *
     * @var boolean
     */
    private $primaryKey;
    /**
     *
     * @var boolean
     */
    private $foreignKey;
    /**
     *
     * @var boolean
     */
    private $uniqueKey;

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

    public function getScale() {
        return $this->scale;
    }

    public function setScale($scale) {
        $this->scale = $scale;
    }

    public function getPrecision() {
        return $this->precision;
    }

    public function setPrecision($precision) {
        $this->precision = $precision;
    }

    public function getPrimaryKey() {
        return $this->primaryKey;
    }

    public function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }

    public function getForeignKey() {
        return $this->foreignKey;
    }

    public function setForeignKey($foreignKey) {
        $this->foreignKey = $foreignKey;
    }

    public function getUniqueKey() {
        return $this->uniqueKey;
    }

    public function setUniqueKey($uniqueKey) {
        $this->uniqueKey = $uniqueKey;
    }

    public function getNullable() {
        return $this->nullable;
    }

    public function setNullable($nullable) {
        $this->nullable = $nullable;
    }

}

?>
