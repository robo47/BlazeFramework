<?php
namespace blaze\ds\meta;

/**
 * Description of ResultSetMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ResultSetMetaData {
    /**
      * @return array[blaze\ds\meta\ColumnMetaData]
      */
     public function getColumns();
     /**
      * @return blaze\ds\meta\ColumnMetaData
      * @param blaze\lang\String|string|int $identifier 
      */
     public function getColumn($identifier);
     /**
      * @return blaze\ds\Statement1
      */
     public function getStatement();
}

?>
