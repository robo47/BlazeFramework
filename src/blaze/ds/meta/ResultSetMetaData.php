<?php
namespace blaze\ds\meta;

/**
 * Description of ResultSetMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
