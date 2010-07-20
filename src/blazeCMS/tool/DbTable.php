<?php
namespace blazeCMS\tool;
use blaze\lang\Object;

/**
 * Description of DbTable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class DbTable extends Object {

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

     public function add(DbColumn $column){
        $this->columns[] = $column;
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
     
}

?>
