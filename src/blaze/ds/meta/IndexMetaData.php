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
    const STRUCTURE_UNKNOWN = 0;
    const STRUCTURE_BTREE = 1;
    const STRUCTURE_HASH = 2;
    const STRUCTURE_BITMAP = 3;

    const TYPE_NONE = 0;
    const TYPE_UNIQUE = 1;
    const TYPE_FULLTEXT = 2;
    const TYPE_SPATIAL = 3;

    /**
     * Drops the index.
     * @return boolean
     */
    public function drop();
    /**
     * @return blaze\lang\String
     */
    public function getIndexName();
    public function setIndexName($indexName);
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();
    public function setTable(TableMetaData $table);
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnIndexEntry]
     */
    public function getColumns();
    public function addColumn($columnName, $prefix = null, $sorting = 'ASC');
    /**
     * The index structure
     * 
     * @return int
     */
    public function getIndexStructure();
    public function setIndexStructure($indexStructure);
    /**
     * The index type
     *
     * @return int
     */
    public function getIndexType();
    public function setIndexType($indexType);
}

?>
