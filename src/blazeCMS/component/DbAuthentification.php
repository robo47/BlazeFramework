<?php
namespace blazeCMS\component;
use blaze\lang\Object,
    blaze\lang\Singleton,
    blazeCMS\model\User;

/**
 * Description of DbAuthentification
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class DbAuthentification extends Object implements Singleton, Authentification {

    /**
     *
     * @var \PDO
     */
    private $con;
    /**
     *
     * @var \PDOStatement
     */
    private $stmt;
    /**
     *
     * @var blazeCMS\component\Authentification
     */
    private static $instance;

    private function __construct() {
        $this->con = \blazeCMS\dao\GenericDAO::getInstance()->getConnection();
        $this->stmt = $this->con->prepare('SELECT * FROM user WHERE user_email = ? AND user_password = ?');
    }

    /**
     * @return blazeCMS\model\User
     */
    public function getUser($user, $password) {
        $this->stmt->bindValue(1, $user, \PDO::PARAM_STR);
        $this->stmt->bindValue(2, $password, \PDO::PARAM_STR);
        $this->stmt->execute();
        $row = $this->stmt->fetch(\PDO::FETCH_ASSOC);

//        if(!isset($row))
//            return null;

        $userObj = new User();
        $userObj->setUserAdded($row['user_added']);
        $userObj->setUserAvailable($row['user_available']);
        $userObj->setUserAvailableFrom($row['user_available_from']);
        $userObj->setUserAvailableTo($row['user_available_to']);
        $userObj->setUserEmail($row['user_email']);
        $userObj->setUserId($row['user_id']);
        $userObj->setUserLastLogin($row['user_last_login']);
        $userObj->setUserMenueMenuId($row['user_menue_menu_id']);
        $userObj->setUserName($row['user_name']);
        $userObj->setUserPassword($row['user_password']);
        $userObj->setUserPersonPersId($row['user_person_pers_id']);

        return $userObj;
    }
    
    /**
     *
     * @return blazeCMS\component\Authentification
     */
    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new DbAuthentification();
        return self::$instance;
    }

}

?>
