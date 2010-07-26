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
 * Description of Admin
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Home extends Object implements \blaze\web\WebView {

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
        $this->textTag->append('<head>'.$this->getPublicHead().'</head>');
        $this->textTag->append('<body>'.$this->getPublicBody().'</body>');
        return $root;
    }

    private function getPublicHead() {
        return '<title>Public Site</title>';
    }

    private function getPublicBody() {
        return 'Hello guys! This is our new site!';
    }
}

?>
