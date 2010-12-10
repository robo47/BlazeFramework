<?php
namespace blaze\persistence\meta;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class TableDescriptor extends Object{

    /**
     *
     * @var \blaze\collections\Map
     */
    private static $tableDescriptors;
    /**
     * The name of the table.
     * @var blaze\lang\String
     */
    private $name;
    /**
     * The schema where the table is in.
     * @var blaze\lang\String
     */
    private $schema;
    /**
     * The columns of a table.
     * @var blaze\collections\ListI[blaze\persistence\meta\ColumnDescriptor]
     */
    private $columns;

    public static function getTableDescriptor($name){
        $name = \blaze\lang\String::asNative($name);
        if(self::$tableDescriptors === null)
            self::$tableDescriptors = array();//new \blaze\collections\map\HashMap();
        $td = isset(self::$tableDescriptors[$name]) ? self::$tableDescriptors[$name] : null;//self::$tableDescriptors->get($name);

        if($td === null){
            $td = new TableDescriptor();
            $td->setName($name);
            self::$tableDescriptors[$name] = $td; //self::$tableDescriptors->put($name, $td);
        }

        return $td;
    }

    public function __construct() {
        $this->columns = new \blaze\collections\lists\ArrayList();
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->name;
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
     * @return blaze\lang\String
     */
    public function getSchema() {
        return $this->schema;
    }

    /**
     *
     * @param string|blaze\lang\String $schema
     */
    public function setSchema($schema) {
        $this->schema = \blaze\lang\String::asWrapper($schema);
    }

    /**
     *
     * @return blaze\collections\ListI[blaze\persistence\meta\ColumnDescriptor]
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     *
     * @param \blaze\persistence\meta\ColumnDescriptor $column
     */
    public function addColumn(\blaze\persistence\meta\ColumnDescriptor $column) {
        $this->columns->add($column);
    }

    public function toString(){
        return $this->name;
    }

}

?>
