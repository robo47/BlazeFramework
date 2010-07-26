<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractIndexMetaData;

/**
 * Description of IndexMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class IndexMetaDataImpl extends AbstractIndexMetaData{

    function __construct(\blaze\ds\meta\TableMetaData $table, $indexName, $unique, $nullable, $indexType) {
        $this->indexName = $indexName;
        $this->table = $table;
        $this->unique = $unique;
        $this->nullable = $nullable;
        $this->indexType = $indexType;
    }

    /**
     * @return blaze\lang\String
     */
    public function getIndexName(){
        return $this->indexName;
    }
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable(){
        return $this->table;
    }
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns(){
        $stmt = null;
        $rs = null;
        $columns = array();

        try{
            $stmt = $this->table->getSchema()
                         ->getDatabaseMetaData()
                         ->getConnection()
                         ->prepareStatement('SHOW INDEX FROM '.$this->table->getSchema()->getSchemaName().'.'.$this->table->getTableName().' WHERE Key_name = \''.$this->indexName->__toString().'\'');
            $stmt->execute();
            $rs = $stmt->getResultSet();

            while($rs->next())
                $columns[] = $this->table->getColumn($rs->getString('Column_name'));
        }catch(\blaze\ds\SQLException $e){}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();

        return $columns;
    }
    /**
     * @return boolean
     */
    public function isUnique(){
        return $this->unique;
    }
    /**
     * @return boolean
     */
    public function isNullable(){
        return $this->nullable;
    }
    /**
     * Btree, Bitmap etc.
     * 
     * @return blaze\lang\String
     */
    public function getIndexType(){
        return $this->indexType;
    }
}

?>
