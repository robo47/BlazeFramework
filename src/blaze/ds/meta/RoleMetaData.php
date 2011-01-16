<?php

namespace blaze\ds\meta;

/**
 * This class represents the meta data of a datasource role which allows to get
 * and set properties of it and also remove, rename it and set privileges.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Add privilege system
 */
interface RoleMetaData {

    /**
     * Drops the role object.
     *
     * @return boolean Wether the action was successfull or not
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns the name of the role.
     *
     * @return blaze\lang\String The name of the role
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getRoleName();
    /**
     * Sets the name of the role.
     *
     * @param string|\blaze\lang\String $roleName The name of the role
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setRoleName($roleName);

    /**
     * Returns the password of the role or null if not supported or available.
     *
     * @return blaze\lang\String The password of the role
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getPassword();

    /**
     * Sets the password of the role. This is maybe ignored because it is not supported by all datasources.
     *
     * @param string|\blaze\lang\String $password The password of the role
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setPassword($password);

    /**
     * Returns the users which are member of the role.
     *
     * @return blaze\collections\ListI[blaze\ds\meta\UserMetaData] The users
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getUsers();

    /**
     * Adds the user with the given username to this role.
     *
     * @param string|\blaze\lang\String $userName The name of the user which to add the role.
     * @param string|\blaze\lang\String $password The password of the user which to add the role.
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addUser($userName, $password);

    /**
     * Removes the user with the given username from this role.
     *
     * @param string|\blaze\lang\String $userName The name of the user which should be removed from this role.
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropUser($userName);


}

?>
