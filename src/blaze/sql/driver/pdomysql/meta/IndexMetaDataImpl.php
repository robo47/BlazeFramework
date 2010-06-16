<?php
namespace blaze\sql\driver\pdomysql\meta;
use blaze\sql\driver\pdobase\meta\AbstractIndexMetaData;

/**
 * Description of IndexMetaDataImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class IndexMetaDataImpl extends AbstractIndexMetaData{
    /**
     * @return blaze\lang\String
     */
    public function getIndexName();
    /**
     * @return blaze\sql\meta\TableMetaData
     */
    public function getTable();
    /**
     * @return blaze\util\ListI[blaze\sql\meta\ColumnMetaData]
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
