<?php
namespace blaze\sql\meta;

/**
 * Description of SchemaMetaData
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface SchemaMetaData {
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
     * @return blaze\util\ListI[blaze\sql\meta\TableMetaData]
     */
    public function getTables();
    /**
     * @return blaze\sql\meta\TableMetaData
     */
    public function getTable($tableName);

}

?>
