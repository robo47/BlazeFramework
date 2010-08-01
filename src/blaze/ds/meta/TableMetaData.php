<?php
namespace blaze\ds\meta;

/**
 * Description of TableMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface TableMetaData {
    /**
     * @return blaze\lang\String
     */
    public function getTableName();
    /**
     * @return blaze\lang\String
     */
    public function getTableComment();
    /**
     * @return blaze\lang\String
     */
    public function getTableCharset();
    /**
     * @return blaze\lang\String
     */
    public function getTableCollation();
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema();

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getColumns();
    /**
     * @return blaze\ds\meta\ColumnMetaData
     */
    public function getColumn($columnName);
    /**
     * @return blaze\util\ListI[blaze\ds\meta\TriggerMetaData]
     */
    public function getTriggers();
    /**
     * @return blaze\ds\meta\TriggerMetaData
     */
    public function getTrigger($triggerName);
    /**
     * @return blaze\util\ListI[blaze\ds\meta\IndexMetaData]
     */
    public function getIndizes();
    /**
     * @return blaze\ds\meta\IndexMetaData
     */
    public function getIndex($indexName);

    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getPrimaryKeys();
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getForeignKeys();
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ColumnMetaData]
     */
    public function getUniqueKeys();
}

?>
