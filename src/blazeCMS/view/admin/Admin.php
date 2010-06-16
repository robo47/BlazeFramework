<?php
namespace blazeCMS\view\admin;
use blaze\lang\Object,
    blaze\web\tagLibrary\HtmlTag,
    blaze\web\tagLibrary\ViewTag,
    blaze\sql\Connection;

/**
 * Description of Admin
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Admin extends Object implements \blaze\web\WebView {

    /**
     *
     * @var blazeCMS\view\TexTag
     */
    private $textTag;
    /**
     *
     * @var blazeCMS\WebContext
     */
    private $context;
    /**
     *
     * @var blazeCMS\component\Authentification
     */
    private $auth;

    function __construct() {
        $this->context = \blazeCMS\WebContext::getInstance();
        $this->textTag = \blazeCMS\view\TextTag::create();
        $this->auth = $this->context->getAttribute('auth');
    }

    public function getComponents() {
        $root = new HtmlTag('http://www.w3.org/1999/xhtml');
        $root->add($this->textTag);
        $this->textTag->append('<head>'.$this->getLoginHead().'</head>');
        $this->textTag->append('<body>'.$this->getLoginBody().'</body>');
        
    $ds = \blaze\sql\DataSourceManager::getInstance()->getDataSource('bdsc:pdomysql://localhost/mydb?uid=root');
    $con = $ds->getConnection();
    $stmt = $con->createStatement();

//    $stmt->addBatch('INSERT INTO user(user_id,user_name,user_email,user_password,user_added,user_last_login,user_available,user_available_from,user_available_to,user_person_pers_id,user_menue_menu_id)
//VALUES(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL);');
//    $stmt->addBatch('INSERT INTO user(user_id,user_name,user_email,user_password,user_added,user_last_login,user_available,user_available_from,user_available_to,user_person_pers_id,user_menue_menu_id)
//VALUES(NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL);');
//    $stmt->executeBatch();

    var_dump($stmt->execute('SELECT * FROM user'));
    var_dump($stmt->getResultSet()->next());
    var_dump($stmt->getResultSet()->next());
        //$c = new \blazeCMS\tool\ClassGenerator();
        //$c->generateForDb(\blaze\lang\ClassLoader::getClassPath());
        //var_dump(\blazeCMS\component\DbAuthentification::getInstance()->getUser('admin@blazebit.com', '123'));
        return $root;
    }

    private function getLoginHead(){
        return '<title>Admin</title>';
    }

    private function getLoginBody(){
        return "<div id='login-center'><div class='title'><h3>Blazebit CMS - Login</h3></div><div id='login'><form id='login-form' action='/admin/login/' method='post'><ul><li><label for='Nick' >Nickname: </label><input type='text' name='Nick' id='Nick' class='input_field'/></li><li><label for='Pass' >Passwort: </label><input type='password' name='Pass' id='Pass' class='input_field'/></li><li><input type='hidden' name='Remember' value='off'/><input type='checkbox' name='Remember' id='Remember' class='checkbox-field' /><label for='Remember' class='remember'>Eingeloggt bleiben?</label></li><li class='last'><input type='submit' name='loginBttn' id='loginBttn' class='submit bttn' value='Login'/></li></ul></form></div></div>";
        //return '';
    }

    private function getCmsHead(){
        return '<title>Admin</title>';
    }

    private function getCmsBody(){
        return 'Hallo Cms!';
    }
}

?>
