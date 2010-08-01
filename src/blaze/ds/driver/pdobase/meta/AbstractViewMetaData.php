<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
    blaze\ds\meta\ViewMetaData;

/**
 * Description of AbstractViewMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractViewMetaData extends Object implements ViewMetaData {
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema();
    /**
     * @return blaze\lang\String
     */
     public function getViewName();
    /**
     * @return blaze\lang\String
     */
     public function getViewDefinition();
    /**
     * @return boolean
     */
     public function isUpdateable();
}

?>
