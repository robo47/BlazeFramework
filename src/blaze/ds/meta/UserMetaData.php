<?php

namespace blaze\ds\meta;

/**
 * This class represents the meta data of a datasource user which allows to get
 * and set properties of it and also remove, rename it and set privileges.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Add privilege system
 */
interface UserMetaData {

    /**
     * Drops the user object.
     *
     * @return boolean Wether the action was successfull or not
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();
    
    /**
     * Returns the name of the user.
     *
     * @return blaze\lang\String The name of the user
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getUserName();
    /**
     * Sets the name of the user.
     *
     * @param string|\blaze\lang\String $userName The name of the user
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setUserName($userName);

    /**
     * Returns the password of the user.
     *
     * @return blaze\lang\String The password of the user
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getPassword();

    /**
     * Sets the password of the user.
     *
     * @param string|\blaze\lang\String $password The password of the user
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setPassword($password);


    /**
     * Returns the roles in which the user is member of.
     *
     * @return blaze\collections\ListI[blaze\ds\meta\RoleMetaData] The roles
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getRoles();

    /**
     * Adds the user to the given role.
     *
     * @param string|\blaze\lang\String $roleName The name of the role in which to add the user.
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function addRole($roleName);

    /**
     * Removes the given role from the user.
     *
     * @param string|\blaze\lang\String $roleName The name of the role of which the user should be removed from.
     * @return blaze\ds\meta\UserMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function dropRole($roleName);


}

?>
