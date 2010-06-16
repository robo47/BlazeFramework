<?php
namespace blaze\sql\driver\pdomysql\meta;
use blaze\sql\driver\pdobase\meta\AbstractSchemaMetaData;

/**
 * Description of SchemaMetaDataImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class SchemaMetaDataImpl extends AbstractSchemaMetaData {
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
