<?php
namespace blaze\persistence\tool;
use blaze\lang\Object;

/**
 * Description of ConstraintMetadata
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ConstraintMetadata extends Object {

    private $constraintName;
    private $constraintType;

    private $tableSchema;
    private $tableName;
    private $columnName;

    private $referencedTableSchema;
    private $referencedTableName;
    private $referencedColumnName;

    public function getConstraintName() {
        return $this->constraintName;
    }

    public function setConstraintName($constraintName) {
        $this->constraintName = $constraintName;
    }

    /**
     *
     * @return blaze\persistence\tool\ConstraintType
     */
    public function getConstraintType() {
        return $this->constraintType;
    }

    /**
     *
     * @param blaze\persistence\tool\ConstraintType $constraintType
     */
    public function setConstraintType($constraintType) {
        $this->constraintType = $constraintType;
    }

    public function getTableSchema() {
        return $this->tableSchema;
    }

    public function setTableSchema($tableSchema) {
        $this->tableSchema = $tableSchema;
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
    }

    public function getColumnName() {
        return $this->columnName;
    }

    public function setColumnName($columnName) {
        $this->columnName = $columnName;
    }

    public function getReferencedTableSchema() {
        return $this->referencedTableSchema;
    }

    public function setReferencedTableSchema($referencedTableSchema) {
        $this->referencedTableSchema = $referencedTableSchema;
    }

    public function getReferencedTableName() {
        return $this->referencedTableName;
    }

    public function setReferencedTableName($referencedTableName) {
        $this->referencedTableName = $referencedTableName;
    }

    public function getReferencedColumnName() {
        return $this->referencedColumnName;
    }

    public function setReferencedColumnName($referencedColumnName) {
        $this->referencedColumnName = $referencedColumnName;
    }

    
}

?>
