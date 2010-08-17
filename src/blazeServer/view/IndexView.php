<?php
namespace blazeServer\view;
use blaze\lang\Object,
    blaze\web\application\WebView,
    blaze\web\component\UIViewRoot,
    blaze\web\component\html\Body,
    blaze\web\component\html\Head,
    blaze\web\component\html\Title,
    blaze\web\component\html\OutputText,
    blaze\web\component\html\CommandLink,
    blaze\web\component\html\Link,
    blaze\web\component\html\CommandButton,
    blaze\web\component\html\Image,
    blaze\web\component\html\Area,
    blaze\web\component\html\Form,
    blaze\web\component\html\DataTable,
    blaze\web\component\html\DataTableColumn,
    blaze\web\component\html\DataTableHeader,
    blaze\web\component\html\DataTableFooter,
        blaze\web\component\html\ContentType,
        blaze\web\component\html\ContentLanguage,
        blaze\web\component\html\Keywords,
        blaze\web\component\html\Description;

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
     *
     * @var blaze\web\component\UIViewRoot
     */
    private $root;

    public function __construct(){
        $this->root = UIViewRoot::create()->setViewId('blazeServer\\view\\IndexView')
                                          ->addChild(Head::create()->addChild(Title::create()->setValue('Index page'))
                                                                   ->addChild(ContentType::create()->setValue('text/html')->setCharset('utf8'))
                                                                   ->addChild(ContentLanguage::create()->setValue('en'))
                                                                   ->addChild(Keywords::create()->setValue('blaze, framework, test, components, eventdriven'))
                                                                   ->addChild(Description::create()->setValue('This is a test of the BlazeFramework which components are implemented to work event driven with.')))
                                          ->addChild(Body::create()->addChild(OutputText::create()->setValue('Test successful!'))
//                                                                   ->addChild(DataTable::create()->setValue('{testList}')
//                                                                                                 ->setVar('tblVar')
//                                                                                                 ->addChild(DataTableColumn::create()->addChild(DataTableHeader::create()->addChild(OutputText::create()->setValue('Firstname')))
//                                                                                                                                     ->addChild(OutputText::create()->setValue('Hehe {tblVar.name}')))
//                                                                                                 ->addChild(DataTableColumn::create()->addChild(DataTableHeader::create()->addChild(OutputText::create()->setValue('Lastname')))
//                                                                                                                                     ->addChild(OutputText::create()->setValue('huhu {tblVar.label}')))
//                                                                                                 ->addChild(DataTableColumn::create()->addChild(DataTableHeader::create()->addChild(OutputText::create()->setValue('Attribute')))
//                                                                                                                                     ->addChild(OutputText::create()->setValue('{tblVar.value} :P'))))
                                                                   ->addChild(Image::create()->setSrc('http://www.justaddfood.co.uk/images/no_image.gif')
                                                                                             ->setId('firstImage')
                                                                                             ->addChild(Area::create()->setAlt('Yeah an area!')
                                                                                                                      ->setShape('rect')
                                                                                                                      ->setCoords('0,0,100,100')
                                                                                                                      ->setHref('http://www.google.at')))
                                                                   ->addChild(Form::create()->setId('myForm')
                                                                                            ->setDestination('')
                                                                                            ->addChild(CommandLink::create()->setId('testNavigate')
                                                                                                                            ->setValue('Navigation test')
                                                                                                                            ->setAction('{test.navigateSomewhere}')
                                                                                                                            ->setActionListener('{test.doSomething}'))
                                                                                            ->addChild(OutputText::create()->setValue(' - '))
                                                                                            ->addChild(CommandLink::create()->setId('testSuccess')
                                                                                                                            ->setValue('Success test')
                                                                                                                            ->setAction('success'))
                                                                                            ->addChild(OutputText::create()->setValue(' - '))
                                                                                            ->addChild(Link::create()->setId('normalLink')
                                                                                                                            ->setValue('Normal link')
                                                                                                                            ->setHref('test'))
                                                                                            ->addChild(OutputText::create()->setValue(' - '))
                                                                                            ->addChild(CommandButton::create()->setId('testButton')
                                                                                                                            ->setValue('Button test')
                                                                                                                            ->setAction('success'))));
//        $this->root = ViewRootTag::create()
//                          ->setViewId('blazeServer\\view\\IndexView')
//                          ->add(ViewTag::create()
//                          ->add(OutputTextTag::create()
//                                             ->setValue('Welcome to the BlazeServer!'))
//                          ->add(OutputTextTag::create()
//                                             ->setValue('This is a test!'))
//                          ->add(FormTag::create()
//                                             ->setId('Form1')
//                                             ->add(InputTextTag::create()
//                                                               ->setName('testInput')
//                                                               ->setValue('{test.name}'))
//                                             ->add(CommandButtonTag::create()
//                                                                   ->setName('testBttn')
//                                                                   ->setValue('Send')
//                                                                   ->setActionListener('{test.doSomething}')
//                                                                   ->setAction('{test.navigateSomewhere}'))
//                                             ->add(CommandButtonTag::create()
//                                                                   ->setName('testBttn1')
//                                                                   ->setValue('Think')
//                                                                   ->setActionListener('{test.doSomething}')
//                                                                   ->setAction('{test.navigateSomewhere}')))
//                          ->add(FormTag::create()
//                                             ->setId('Form2')
//                                             ->add(InputTextTag::create()
//                                                               ->setName('testInput')
//                                                               ->setValue('{test.name}'))
//                                             ->add(CommandButtonTag::create()
//                                                                   ->setName('testBttn')
//                                                                   ->setValue('Send')
//                                                                   ->setActionListener('{test.doSomething}')
//                                                                   ->setAction('{test.navigateSomewhere}'))
//                                             ->add(CommandButtonTag::create()
//                                                                   ->setName('testBttn1')
//                                                                   ->setValue('Think')
//                                                                   ->setActionListener('{test.doSomething}')
//                                                                   ->setAction('{test.navigateSomewhere}')))
//                  );
    }

    public function getViewRoot(){
        return $this->root;
     }
}

?>
