<?php
namespace webapp\helloWorld\view;
use blaze\lang\Object,
    blaze\web\application\WebView,
    blaze\web\tag\HtmlTag,
    blaze\web\tag\ViewTag,
    blaze\web\tag\OutputTextTag,
    blaze\web\tag\HeadTag,
    blaze\web\tag\ScriptTag,
    blaze\web\tag\PanelTag,
    blaze\web\tag\ButtonTag,
    blaze\web\tag\ClickEventTag,
    blaze\web\tag\SlidePanelTag,
    blaze\web\tag\EnlargePanelTag,
    blaze\web\tag\CustomHandlerTag,
    blaze\web\JSContainer;

/**
 * Description of IndexView
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class IndexView extends Object implements WebView{

    /**
     * Description
     */
    public function __construct(){

    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
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
