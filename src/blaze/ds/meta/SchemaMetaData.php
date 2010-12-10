<?php
namespace blaze\ds\meta;

/**
 * Description of SchemaMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface SchemaMetaData {

    /**
     * @return blaze\ds\meta\DatabaseMetaData
     */
    public function getDatabaseMetaData();
    /**
     * Drops the schema.
     * @return boolean
     */
    public function drop();
    /**
     * @return blaze\lang\String
     */
    public function getSchemaName();
    /**
     * @param string|blaze\lang\String $schemaName
     * @return boolean
     */
    public function setSchemaName($schemaName);
    /**
     * @return blaze\lang\String
     */
    public function getSchemaCharset();
    /**
     * @param string|blaze\lang\String $schemaCharset
     * @return boolean
     */
    public function setSchemaCharset($schemaCharset);
    /**
     * @return blaze\lang\String
     */
    public function getSchemaCollation();
    /**
     * @param string|blaze\lang\String $schemaCollation
     * @return boolean
     */
    public function setSchemaCollation($schemaCollation);
    
    /**
     * @return blaze\util\ListI[blaze\ds\meta\TableMetaData]
     */
    public function getTables();
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable($tableName);
    public function dropTable($tableName);
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function createTable($tableName, $charset = null, $collation = null, $comment = null);
    
    public function addTable(TableMetaData $table);
    /**
     * @return blaze\util\ListI[blaze\ds\meta\ViewMetaData]
     */
    public function getViews();
    /**
     * @return blaze\ds\meta\ViewMetaData
     */
    public function getView($viewName);
    public function dropView($viewName);
    /**
     * @return blaze\ds\meta\ViewMetaData
     */
    public function createView($viewName, $viewDefinition);

}

?>
