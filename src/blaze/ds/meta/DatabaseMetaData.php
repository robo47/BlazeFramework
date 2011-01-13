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
     * @return blaze\ds\Connection The underlying connection.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getConnection();

    /**
     * Drops the datasource object.
     *
     * @return blaze\ds\meta\DatabaseMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the host with which the datasource is connected.
     *
     * @return blaze\lang\String The host
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getHost();

    /**
     * Returns the username with which the datasource is connected.
     *
     * @return blaze\lang\String The username
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getUsername();

    /**
     * Returns the name of the datasource object.
     *
     * @return blaze\lang\String The name of the datasource object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabaseName();

    /**
     * Sets a new name for the current datasource object. Some datasources do
     * not support this action and throw a DataSourceException with the error code -1.
     *
     * @param string|blaze\lang\String $name The new name of the datasource object.
     * @return boolean Wether the action was successfull or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setDatabaseName($name);

    /**
     * Adds the role to the datasource object and returns the RoleMetaData.
     *
     * @param string|\blaze\lang\String $roleName The name of the role.
     * @param string|\blaze\lang\String $password The optional password for the role. This is not supported by all datasources.
     * @return blaze\ds\meta\RoleMetaData The created RoleMetaData.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addRole($roleName, $password = null);

    /**
     * Returns the meta data object of the role with the specified name, if no
     * role with the given name is available, null is returned.
     *
     * @param string|\blaze\lang\String $name The role name
     * @return \blaze\ds\meta\UserMetaData The metadata of the user
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getRole($name);

    /**
     * Drops the role with the given name.
     *
     * @param string|\blaze\lang\String $name The role name
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropRole($name);
    
    /**
     * Returns a list of meta data objects of the roles which are available at the
     * datasource end.
     *
     * @return \blaze\collections\ListI[\blaze\ds\meta\RoleMetaData] The metadata of the roles
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getRoles();

    /**
     * Adds the user to the datasource object and returns the UserMetaData.
     *
     * @param string|\blaze\lang\String $roleName The name of the user.
     * @param string|\blaze\lang\String $password The password for the user.
     * @return blaze\ds\meta\RoleMetaData The created UserMetaData.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addUser($userName, $password);

    /**
     * Returns the meta data object of the user with the specified name, if no
     * user with the given name is available, null is returned.
     * It returns the user with which the datasource is connected if the name is null.
     *
     * @param string|\blaze\lang\String $name The user name
     * @return \blaze\ds\meta\UserMetaData The metadata of the user
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getUser($name = null);

    /**
     * Drops the user with the given name.
     *
     * @param string|\blaze\lang\String $name The user name
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropUser($name);

    /**
     * Returns a list of meta data objects of the users which are available at the
     * datasource end.
     *
     * @return \blaze\collections\ListI[\blaze\ds\meta\UserMetaData] The metadata of the users
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getUsers();

    /**
     * Returns the port with which the datasource is connected.
     *
     * @return int The port
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getPort();

    /**
     * Returns the options which were used to configure the datasource.
     *
     * @return \blaze\collections\map\Properties The options
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getOptions();

    /**
     * Returns the name of the datasource endpoint product.
     *
     * @return blaze\lang\String The name of the datasource end
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabaseProductName();

    /**
     * Returns the version of the datasource endpoint product.
     *
     * @return blaze\lang\String The version of the datasource end
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabaseProductVersion();

    /**
     * Returns the charset which is used by the datasource as default.
     *
     * @return blaze\lang\String The charset of the datasource end
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabaseCharset();

    /**
     * Returns the collation which is used by the datasource as default.
     *
     * @return blaze\lang\String The collation of the datasource end
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDatabaseCollation();

    /**
     * Sets the charset which is used by the datasource as default.
     *
     * @param string|\blaze\lang\String $databaseCharset The charset of the datasource end
     * @return blaze\ds\meta\DatabaseMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setDatabaseCharset($databaseCharset);

    /**
     * Sets the collation which is used by the datasource as default.
     *
     * @param string|\blaze\lang\String $databaseCollation The collation of the datasource end
     * @return blaze\ds\meta\DatabaseMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setDatabaseCollation($databaseCollation);

    /**
     * Returns the name of the drive which is used to connect to the datasource.
     *
     * @return blaze\lang\String The name of the driver
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDriverName();

    /**
     * Returns the version of the drive which is used to connect to the datasource.
     *
     * @return blaze\lang\String The version of the driver
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getDriverVersion();

    /**
     * Returns the schemas in a list which are a subgroup of the datasource object.
     *
     * @return blaze\util\ListI[blaze\ds\meta\SchemaMetaData] The schemas of the datasource object
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchemas();

    /**
     * Returns the schema with the given name of this datasource object.
     *
     * @param string|\blaze\lang\String $schemaName The name of the schema
     * @return blaze\ds\meta\SchemaMetaData The schema with the given name or null
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getSchema($schemaName);

    /**
     * Drops the schema with the given name from this datasource object.
     *
     * @param string|\blaze\lang\String $schemaName The name of the schema
     * @return blaze\ds\meta\DatabaseMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropSchema($schemaName);

    /**
     * Removes the schema from the datasource object by name and uninitializes it, but does not
     * throw an exception if it does not exist.
     *
     * @param string|\blaze\lang\String $schemaName The name of the schema
     * @return blaze\ds\meta\DatabaseMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropSchemaIfExists($schemaName);

    /**
     * Creates a new schema object within this datasourc object.
     *
     * @param string|\blaze\lang\String $schemaName The name of the schema
     * @param string|\blaze\lang\String $charset The charset of the schema
     * @param string|\blaze\lang\String $collation The collation of the schema
     * @return blaze\ds\meta\SchemaMetaData The created schema
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function createSchema($schemaName, $charset = null, $collation = null);

    /**
     * Adds the schema to the datasource object recursively and returns the new schema.
     *
     * @param string|\blaze\lang\String $newName This name overrides the one given in the object.
     * @return blaze\ds\meta\DatabaseMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addSchema(SchemaMetaData $schema, $newName = null);
}

?>
