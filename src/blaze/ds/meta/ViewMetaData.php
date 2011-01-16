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
     * @return blaze\ds\meta\SchemaMetaData The parent schema object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchema();

    /**
     * Drops the view.
     *
     * @return boolean Wether the action was successful or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the name of the view.
     *
     * @return blaze\lang\String The name of the view
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getViewName();

    /**
     * Sets the name of the view.
     *
     * @param string|\blaze\lang\String $viewName The name of the view
     * @return blaze\ds\meta\ViewMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setViewName($viewName);

    /**
     * Returns the definition of the view.
     *
     * @return blaze\lang\String The definition of the view
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getViewDefinition();

    /**
     * Sets the definition of the view.
     *
     * @param string|\blaze\lang\String $viewDefinition The definition of the view
     * @return blaze\ds\meta\ViewMetaData This object for chaining
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setViewDefinition($viewDefinition);

    /**
     * Returns wether the view is updateable or not.
     *
     * @return boolean True if the view is updateable, otherwise false
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function isUpdateable();
}

?>
