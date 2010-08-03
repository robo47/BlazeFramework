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
    blaze\web\component\html\Form;

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
class SuccessView extends Object implements WebView{

    /**
     *
     * @var blaze\web\component\UIViewRoot
     */
    private $root;

    public function __construct(){
        $this->root = UIViewRoot::create()->setViewId('blazeServer\\view\\SuccessView')
                            ->addChild(Head::create()
                                            ->addChild(Title::create()
                                                            ->setValue('Success page')))
                            ->addChild(Body::create()
                                            ->addChild(OutputText::create()->setValue('Success View')));
    }

    public function getViewRoot(){
        return $this->root;
     }

}

?>
