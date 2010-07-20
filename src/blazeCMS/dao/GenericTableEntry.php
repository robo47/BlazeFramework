<?php
namespace blazeCMS\dao;
use blaze\lang\Object;

/**
 * Description of GenericTableEntry
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class GenericTableEntry extends Object {

    /**
     *
     * @var Talbe
     */
    private $table;
    /**
     *
     * @var array
     */
    private $values;

    /**
     * Beschreibung
     */
    public function __construct($table){
        $this->table = $table;
        $this->values = array();
    }
    /**
     *
     * @return Table
     */
    public function getTable() {
        return $this->table;
    }

    /**
     *
     * @param Table $table
     * @return GenericTableEntry
     */
    public function setTable(Table $table) {
        $this->table = $table;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getValues() {
        return $this->values;
    }

    /**
     *
     * @param array $values
     * @return GenericTableEntry
     */
    public function setValues($values) {
        $this->values = $values;
        return $this;
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    public function getValue($name) {
        return array_key_exists($name,$this->values) ? $this->values[$name] : null;
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return GenericTableEntry
     */
    public function setValue($name, $value) {
        $this->values[$name] = $values;
        return $this;
    }


}

?>
