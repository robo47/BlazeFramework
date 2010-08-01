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
     * @return blaze\lang\String
     */
    public function getSchemaName();
    /**
     * @return blaze\lang\String
     */
    public function getSchemaCharset();
    /**
     * @return blaze\lang\String
     */
    public function getSchemaCollation();
    
    /**
     * @return blaze\util\ListI[blaze\ds\meta\TableMetaData]
     */
    public function getTables();
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable($tableName);

}

?>
