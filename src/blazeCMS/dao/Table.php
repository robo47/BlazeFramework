<?php
namespace blazeCMS\dao;
use blaze\lang\Object;

/**
 * Description of Table
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Table extends Object {

    /**
     *
     * @var string
     */
    private $tableName;
    /**
     *
     * @var Column
     */
    private $id;
    /**
     *
     * @var array[Column]
     */
    private $columns;

    /**
     * Beschreibung
     */
    public function __construct(){

    }

    /**
     *
     * @return string
     */
    public function getTableName() {
        return $this->tableName;
    }

    /**
     *
     * @param string $tableName
     * @return Table
     */
    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     *
     * @return Column
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @param Column $id
     * @return Table
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    /**
     *
     * @return array[Column]
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     *
     * @param array[Column] $columns
     * @return Table
     */
    public function setColumns($columns) {
        $this->columns = $columns;
        return $this;
    }

    /**
     *
     * @param Column $column
     * @return Table
     */
    public function addColumn(Column $column) {
        $this->columns[] = $column;
        return $this;
    }

    public function getColumnsAsString(){
        return implode(',', $this->columns);
    }

    /**
     *
     * @return GenericTableEntry 
     */
    public function createTableEntry(){
        return new GenericTableEntry($table);
    }

}

?>
