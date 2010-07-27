<?php
namespace blazeCMS\view\general;
use blaze\lang\Object,
blaze\util\Date,
blaze\web\tagLibrary\HtmlTag,
blaze\web\tagLibrary\ViewTag,
blaze\web\tagLibrary\PlainTag,
blaze\ds\Connection,
blaze\ds\SQLException,
blaze\lang\String;

/**
 * Description of Login
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Login extends Object implements \blaze\web\application\WebView {

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

    function __construct() {
        $this->context = \blazeCMS\WebContext::getInstance();
        $this->textTag = \blazeCMS\view\TextTag::create();
    }

    public function getComponents() {
        $root = new HtmlTag('http://www.w3.org/1999/xhtml');
        $root->add($this->textTag);
        $this->textTag->append('<head><title>Login</title></head>');
        $this->textTag->append('<body><div id="login-center"><div class="title"><h3>Blazebit CMS - Login</h3></div><div id="login"><form id="login-form" action="/admin/login/" method="post"><ul><li><label for="Nick" >Nickname: </label><input type="text" name="Nick" id="Nick" class="input_field"/></li><li><label for="Pass" >Passwort: </label><input type="password" name="Pass" id="Pass" class="input_field"/></li><li><input type="hidden" name="Remember" value="off"/><input type="checkbox" name="Remember" id="Remember" class="checkbox-field" /><label for="Remember" class="remember">Eingeloggt bleiben?</label></li><li class="last"><input type="submit" name="loginBttn" id="loginBttn" class="submit bttn" value="Login"/></li></ul></form></div></div></body>');

        return $root;
    }
}

?>
