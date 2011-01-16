<?php

namespace blaze\ds\driver\pdomysql\meta;

use blaze\ds\driver\pdobase\meta\AbstractForeignKeyMetaData;

/**
 * Description of ForeignKeyMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class UserMetaDataImpl extends \blaze\ds\driver\pdobase\meta\AbstractUserMetaData{

    private $dbmd;

    public function __construct(\blaze\ds\meta\DatabaseMetaData $dbmd, $userName){
        $this->dbmd = $dbmd;
        $this->userName = $userName;
    }

    public function addRole($roleName) {

    }

    public function drop() {
        $this->dbmd->dropUser($this->userName);
    }

    public function dropRole($roleName) {
        return $this;
    }

    public function getPassword() {
        $stmt = null;
        $rs = null;
        $pw = null;

        try {
            $stmt = $this->con->prepareStatement('SELECT password FROM mysql.user WHERE user = ?');
            $stmt->setString(0, $this->userName);
            $rs = $stmt->executeQuery();

            if($rs->next())
                $pw = $rs->getString(0);
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), null, $e->getCode(), $e);
        }

        if ($stmt != null)
            $stmt->close();
        if ($rs != null)
            $rs->close();

        return $pw;
    }

    public function getRoles() {
        return $this->dbmd->getRoles();
    }

    public function setPassword($password) {
        $stmt = null;

        try {
            $stmt = $this->con->prepareStatement('SET PASSWORD FOR ? = PASSWORD(?)');
            $stmt->setString(0, $this->userName);
            $stmt->setString(1, $password);
            $stmt->executeUpdate();
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), null, $e->getCode(), $e);
        }

        if ($stmt != null)
            $stmt->close();
        return $this;
    }

    public function setUserName($userName) {
        $stmt = null;

        try {
            $stmt = $this->con->prepareStatement('RENAME USER ? TO ?');
            $stmt->setString(0, $this->userName);
            $stmt->setString(1, $username);
            $stmt->executeUpdate();
            $this->userName = $userName;
        } catch (\PDOException $e) {
            throw new \blaze\ds\DataSourceException($e->getMessage(), null, $e->getCode(), $e);
        }

        if ($stmt != null)
            $stmt->close();
        return $this;
    }



}

?>
