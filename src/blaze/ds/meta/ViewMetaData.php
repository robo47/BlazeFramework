<?php

namespace blaze\ds\meta;

/**
 * This class represents a view of a schema object which can be dropped and
 * changed.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface ViewMetaData {

    /**
     * Returns the parent schema object.
     *
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema();

    /**
     * Drops the view.
     *
     * @return boolean
     */
    public function drop();

    /**
     * Returns the name of the view.
     *
     * @return blaze\lang\String
     */
    public function getViewName();

    /**
     * Sets the name of the view.
     *
     * @param string|\blaze\lang\String $viewName
     */
    public function setViewName($viewName);

    /**
     * Returns the definition of the view.
     *
     * @return blaze\lang\String
     */
    public function getViewDefinition();

    /**
     * Sets the definition of the view.
     *
     * @param string|\blaze\lang\String $viewDefinition
     */
    public function setViewDefinition($viewDefinition);

    /**
     * Returns wether the view is updateable or not.
     *
     * @return boolean
     */
    public function isUpdateable();
}

?>
