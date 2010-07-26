<?php
namespace blaze\ds\meta;

/**
 * Description of ResultSetMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface ResultSetMetaData {
    /**
      * @return array[blaze\ds\meta\ColumnMetaData]
      */
     public function getColumns();
     /**
      * @return blaze\ds\meta\ColumnMetaData
      * @param blaze\lang\String|string|integer $identifier 
      */
     public function getColumn($identifier);
     /**
      * @return blaze\ds\Statement1
      */
     public function getStatement();
}

?>
