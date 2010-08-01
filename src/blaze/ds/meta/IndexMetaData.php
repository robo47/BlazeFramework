<?php
namespace blaze\ds\meta;

/**
 * Description of IndexMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface IndexMetaData {
    /**
     * @return blaze\lang\String
     */
    public function getIndexName();
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns();
    /**
     * @return boolean
     */
    public function isUnique();
    /**
     * @return boolean
     */
    public function isNullable();
    /**
     * Btree, Bitmap etc.
     * 
     * @return blaze\lang\String
     */
    public function getIndexType();
}

?>
