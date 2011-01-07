<?php

namespace blaze\ds\meta;

/**
 * This class represents the meta data of a datasource object which allows to get
 * and set properties of it and also remove, rename it and create/remove subtypes (schemas).
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface DatabaseMetaData {

    /**
     * Returns the underlying connection which has been used to get this
     * database meta data.
     *
     * @return blaze\ds\Connection
     */
    public function getConnection();

    /**
     * Drops the datasource object.
     *
     * @return boolean
     */
    public function drop();

    /**
     * Returns the host with which the datasource is connected.
     *
     * @return blaze\lang\String
     */
    public function getHost();

    /**
     * Returns the name of the datasource object.
     *
     * @return blaze\lang\String
     */
    public function getDatabaseName();

    /**
     * Sets a new name for the current datasource object.
     *
     * @param string|blaze\lang\String $name The new name of the datasource object.
     * @return boolean Wether the action was successfull or not.
     */
    public function setDatabaseName($name);

    /**
     * Returns the username with which the datasource is connected.
     *
     * @return blaze\lang\String
     */
    public function getUser();

    /**
     * Returns the port with which the datasource is connected.
     *
     * @return int
     */
    public function getPort();

    /**
     * Returns the options which were used to configure the datasource.
     *
     * @return array
     */
    public function getOptions();

    /**
     * Returns the name of the datasource endpoint product.
     *
     * @return blaze\lang\String
     */
    public function getDatabaseProductName();

    /**
     * Returns the version of the datasource endpoint product.
     *
     * @return blaze\lang\String
     */
    public function getDatabaseProductVersion();

    /**
     * Returns the charset which is used by the datasource as default.
     *
     * @return blaze\lang\String
     */
    public function getDatabaseCharset();

    /**
     * Returns the collation which is used by the datasource as default.
     *
     * @return blaze\lang\String
     */
    public function getDatabaseCollation();

    /**
     * Sets the charset which is used by the datasource as default.
     *
     * @param string|\blaze\lang\String $databaseCharset
     */
    public function setDatabaseCharset($databaseCharset);

    /**
     * Sets the collation which is used by the datasource as default.
     *
     * @param string|\blaze\lang\String $databaseCollation
     */
    public function setDatabaseCollation($databaseCollation);

    /**
     * Returns the name of the drive which is used to connect to the datasource.
     *
     * @return blaze\lang\String
     */
    public function getDriverName();

    /**
     * Returns the version of the drive which is used to connect to the datasource.
     *
     * @return blaze\lang\String
     */
    public function getDriverVersion();

    /**
     * Returns the schemas in a list which are a subgroup of the datasource object.
     *
     * @return blaze\util\ListI[blaze\ds\meta\SchemaMetaData]
     */
    public function getSchemas();

    /**
     * Returns the schema with the given name of this datasource object.
     *
     * @return blaze\ds\meta\SchemaMetaData
     */
    public function getSchema($schemaName);

    /**
     * Drops the schema with the given name from this datasource object.
     *
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropSchema($schemaName);

    /**
     * Removes the schema from the datasource object by name and uninitializes it, but does not
     * throw an exception if it does not exist.
     *
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropIfExistsSchema($schemaName);

    /**
     * Creates a new schema object within this datasourc object.
     *
     * @return blaze\ds\meta\SchemaMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createSchema($name, $charset = null, $collation = null);

    /**
     * Adds the schema to the datasource object recursively and returns the new schema.
     *
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\SchemaMetaData
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addSchema(SchemaMetaData $schema, $newName = null);
}

?>
