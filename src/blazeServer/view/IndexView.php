<?php
namespace blazeServer\view;
use blaze\lang\Object,
    blaze\web\application\WebView,
    blaze\web\tag\ViewRootTag,
    blaze\web\tag\ViewTag,
    blaze\web\tag\OutputTextTag,
    blaze\web\tag\InputTextTag,
    blaze\web\tag\FormTag,
    blaze\web\tag\CommandButtonTag;

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
        $this->root = new \blaze\web\component\UIViewRoot();
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
