<?php
namespace blaze\persistence\tool;
use blaze\lang\Object;

/**
 * Description of TableMetadata
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class TableMetadata extends Object {

    /**
     *
     * @var array
     */
    private $columns = array();
    /**
     *
     * @var string
     */
    private $tableName;
    /**
     *
     * @var string
     */
    private $schema;

     public function addColumn(ColumnMetadata $column){
        $this->columns[] = $column;
     }

     public function addConstraint(ConstraintMetadata $column){
        $this->constraints[] = $column;
     }

     public function getTableName() {
         return $this->tableName;
     }

     public function setTableName($tableName) {
         $this->tableName = $tableName;
     }

     public function getSchema() {
         return $this->schema;
     }

     public function setSchema($schema) {
         $this->schema = $schema;
     }

     public function getColumns() {
         return $this->columns;
     }

     public function getConstraints(){
         $constraints = array();

         foreach($this->columns as $column)
                 $constraints[] = $column->getConstraints();

         return array_merge($constraints);
     }
     
}

?>
