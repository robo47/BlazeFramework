<?php
namespace blazeServer\view;
use blaze\lang\Object,
    blaze\web\application\WebView,
    blaze\web\tagLibrary\HtmlTag,
    blaze\web\tagLibrary\ViewTag,
    blaze\web\tagLibrary\OutputTextTag;

/**
 * Description of IndexView
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class TestView extends Object implements WebView{

    /**
     * Beschreibung
     */
    public function __construct(){

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
                                             ->setValue('This is the TestView'))
                          ->add(OutputTextTag::create()
                                             ->setValue('Just a test!'))
                  );
        return $root;
     }
     
     public static function getActionDefinitions() {
        return array();
     }

     public static function getParamDefinitions() {
        return array();
     }

}

?>
