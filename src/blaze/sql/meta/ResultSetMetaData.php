<?php
namespace blaze\sql\meta;

/**
 * Description of ResultSetMetaData
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface ResultSetMetaData {
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
