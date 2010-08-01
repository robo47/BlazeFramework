<?php
namespace blazeCMS\view\general;
use blaze\lang\Object,
    blaze\web\application\WebView,
    blaze\web\tag\ViewRootTag,
    blaze\web\tag\ViewTag,
    blaze\web\tag\OutputTextTag,
    blaze\web\tag\InputTextTag,
    blaze\web\tag\FormTag,
    blaze\web\tag\CommandButtonTag,
    blaze\web\param\Parameter,
    blaze\web\param\Action;

/**
 * Description of Home
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Home extends Object implements WebView{

    /**
     *
     * @var blaze\web\tag\Tag
     */
    private $root;
    
    public function __construct(){
        $this->root = ViewRootTag::create()
                          ->add(ViewTag::create()
                          ->add(OutputTextTag::create()
                                             ->setValue('Home page, es gibt noch <a href="test">/test</a> oder <a href="server">/server</a>'))
                  );
    }

    public function processApplication(\blaze\web\application\BlazeContext $context) {
        $this->root->processApplication($context);
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        $this->root->processDecodes($context);
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        $this->root->processUpdates($context);
    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {
        $this->root->processValidations($context);
    }

    public function getViewRoot(){
        return $this->root;
     }
}

?>
