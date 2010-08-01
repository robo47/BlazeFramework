<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractForeignKeyMetaData;

/**
 * Description of ForeignKeyMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
        return $this->referencedColumn;
    }
}

?>
