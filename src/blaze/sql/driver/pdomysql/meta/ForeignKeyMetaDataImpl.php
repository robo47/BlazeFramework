<?php
namespace blaze\sql\driver\pdomysql\meta;
use blaze\sql\driver\pdobase\meta\AbstractForeignKeyMetaData;

/**
 * Description of ForeignKeyMetaDataImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ForeignKeyMetaDataImpl extends AbstractForeignKeyMetaData {

    /**
     * @return blaze\lang\String
     */
    public function getName();
    /**
     * @return blaze\sql\meta\TableMetaData
     */
    public function getTable();
    /**
     * @return blaze\sql\meta\TableMetaData
     */
    public function getReferencedTable();
    /**
     * @return blaze\sql\meta\ColumnMetaData
     */
    public function getColumn();
    /**
     * @return blaze\sql\meta\ColumnMetaData
     */
    public function getReferencedColumn();
}

?>
