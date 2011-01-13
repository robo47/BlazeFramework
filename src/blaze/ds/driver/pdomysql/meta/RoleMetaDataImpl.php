<?php

namespace blaze\ds\driver\pdomysql\meta;

/**
 * Pass through to DatabaseMetaData because MySQL does not support roles.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class RoleMetaDataImpl extends \blaze\ds\driver\pdobase\meta\AbstractRoleMetaData{

    private $dbmd;

    public function __construct(\blaze\ds\meta\DatabaseMetaData $dbmd){
        $this->dbmd = $dbmd;
    }

    public function addUser($userName, $password) {
        $this->dbmd->addUser($userName, $password);
    }

    public function drop() {
        return false;
    }

    public function dropUser($userName) {
        $this->dbmd->dropUser($userName);
    }

    public function getPassword() {
        return null;
    }

    public function getUsers() {
        return $this->dbmd->getUsers();
    }

    public function setPassword($password) {
        return $this;
    }

    public function setRoleName($roleName) {
        return $this;
    }


}

?>
