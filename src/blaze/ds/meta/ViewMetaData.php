<?php
namespace blaze\ds\meta;

/**
 * Description of ViewMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface ViewMetaData {
    /**
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema();
    /**
     * Drops the view.
     * @return boolean
     */
    public function drop();
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
