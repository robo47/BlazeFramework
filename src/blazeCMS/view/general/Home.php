<?php
namespace blazeCMS\view\general;
use blaze\lang\Object,
    blaze\web\application\WebView,
    blaze\web\tagLibrary\HtmlTag,
    blaze\web\tagLibrary\ViewTag,
    blaze\web\tagLibrary\OutputTextTag,
    blaze\web\tagLibrary\InputTextTag,
    blaze\web\tagLibrary\FormTag,
    blaze\web\tagLibrary\CommandButtonTag,
    blaze\web\param\Parameter,
    blaze\web\param\Action;

/**
 * Description of Home
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Home extends Object implements WebView{

    /**
     * Beschreibung
     */
    public function __construct(){

    }

    public static function getParamDefinitions(){
        return array(new Parameter('testInput', '', '{test.name}', new \blaze\web\validator\IntegerValidator(), new \blaze\web\converter\IntegerConverter(), false));
    }

    public static function getActionDefinitions(){
        return array(new Action('testBttn', '{test.doSomething}', '{test.navigateSomewhere}'));
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public function getComponents(){
        $root = new HtmlTag('http://www.w3.org/1999/xhtml');
        $root->add(ViewTag::create()
                          ->add(OutputTextTag::create()
                                             ->setValue('Home page, es gibt noch <a href="test">/test</a> oder <a href="server">/server</a>'))
                  );
        return $root;
     }
}

?>
