<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractForeignKeyMetaData;

/**
 * Description of ForeignKeyMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ForeignKeyMetaDataImpl extends AbstractForeignKeyMetaData {

    /**
     *
     * @param array[\blaze\ds\meta\ColumnMetaData] $columns
     * @param array[\blaze\ds\meta\ColumnMetaData] $referencedColumns
     * @param blaze\lang\String $constraintName
     */
    public function __construct($columns, \blaze\ds\meta\ColumnMetaData $referencedColumns, $constraintName){
        $this->columns = $columns;
        $this->referencedColumns = $referencedColumns;
        $this->constraintName = $constraintName;
        $this->constraintType = 'FOREIGN KEY';
    }

    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getReferencedColumn(){
        return $this->referencedColumns;
    }
    
    public function addColumn(\blaze\ds\meta\ColumnMetaData $column) {

    }

    public function drop() {

    }

    public function removeColumn(\blaze\ds\meta\ColumnMetaData $column) {

    }

    public function setConstraintName() {

    }

    public function setReferencedColumn(\blaze\ds\meta\ColumnMetaData $referencedColumn) {

    }

}

?>
