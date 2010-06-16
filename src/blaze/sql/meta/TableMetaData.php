<?php
namespace blaze\sql\meta;

/**
 * Description of TableMetaData
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
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
     * @return blaze\sql\meta\SchemaMetaData
     */
    public function getSchema();

    /**
     * @return blaze\util\ListI[blaze\sql\meta\ColumnMetaData]
     */
    public function getColumns();
    /**
     * @return blaze\sql\meta\ColumnMetaData
     */
    public function getColumn($columnName);
    /**
     * @return blaze\util\ListI[blaze\sql\meta\TriggerMetaData]
     */
    public function getTriggers();
    /**
     * @return blaze\sql\meta\TriggerMetaData
     */
    public function getTrigger($triggerName);
    /**
     * @return blaze\util\ListI[blaze\sql\meta\IndexMetaData]
     */
    public function getIndizes();
    /**
     * @return blaze\sql\meta\IndexMetaData
     */
    public function getIndex($indexName);

    /**
     * @return blaze\util\ListI[blaze\sql\meta\ColumnMetaData]
     */
    public function getPrimaryKeys();
    /**
     * @return blaze\util\ListI[blaze\sql\meta\ColumnMetaData]
     */
    public function getForeignKeys();
    /**
     * @return blaze\util\ListI[blaze\sql\meta\ColumnMetaData]
     */
    public function getUniqueKeys();
}

?>
