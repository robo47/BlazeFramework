<?php
namespace blaze\ds\meta;

/**
 * Description of ViewMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


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
