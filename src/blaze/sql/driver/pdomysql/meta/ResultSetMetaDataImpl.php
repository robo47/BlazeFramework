<?php
namespace blaze\sql\driver\pdomysql\meta;
use blaze\sql\driver\pdobase\meta\AbstractResultSetMetaData;

/**
 * Description of ResultSetMetaDataImpl
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ResultSetMetaDataImpl extends AbstractResultSetMetaData {
    /**
      * @return array[blaze\sql\meta\ColumnMetaData]
      */
     public function getColumns();
     /**
      * @return blaze\sql\meta\ColumnMetaData
      * @param blaze\lang\String|string|integer $identifier 
      */
     public function getColumn($identifier);
}

?>
