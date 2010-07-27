<?php
namespace webapp\helloWorld\view;
use blaze\lang\Object,
    blaze\web\application\WebView,
    blaze\web\tagLibrary\HtmlTag,
    blaze\web\tagLibrary\ViewTag,
    blaze\web\tagLibrary\OutputTextTag,
    blaze\web\tagLibrary\HeadTag,
    blaze\web\tagLibrary\ScriptTag,
    blaze\web\tagLibrary\PanelTag,
    blaze\web\tagLibrary\ButtonTag,
    blaze\web\tagLibrary\ClickEventTag,
    blaze\web\tagLibrary\SlidePanelTag,
    blaze\web\tagLibrary\EnlargePanelTag,
    blaze\web\tagLibrary\CustomHandlerTag,
    blaze\web\JSContainer;

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
class IndexView extends Object implements WebView{

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
        $root->add(HeadTag::create()
                          ->add(ScriptTag::create()
                                         ->setContent('alert(\'test\');')))
             ->add(ViewTag::create()
                          ->add(OutputTextTag::create()
                                             ->setValue('Hello World!'))
                          ->add(PanelTag::create()
                                        ->setId('test')
                                        ->add(OutputTextTag::create()
                                                           ->setValue('This is a test!')))
                          ->add(ButtonTag::create()
                                         ->setValue('test'))
                          ->add(ButtonTag::create()
                                         ->setValue('eventTest')
                                         ->add(ClickEventTag::create()
                                                            ->add(SlidePanelTag::create()
                                                                               ->setForId('test')
                                                                               ->setDuration('100')
                                                                               ->setDelay('0')
                                                                               ->setDirection('vertical')
                                                                               ->add(CustomHandlerTag::create()
                                                                                                     ->setName('myHandler')
                                                                                                     ->setContent('alert(\'slided down!\');')))
                                                            ->add(EnlargePanelTag::create()
                                                                                 ->setForId('test')
                                                                                 ->setDuration('100')
                                                                                 ->setDelay('20'))
                                              )
                               )
                  );
        $children = $root->getChildren();
        $children[1]->add(ScriptTag::create()
                                   ->setContent(JSContainer::getInstance()->getContent()));
        return $root;
     }
}

?>
