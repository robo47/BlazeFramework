<?php
namespace blaze\web\component;
use blaze\lang\Object;

/**
 * Description of UIComponentCore
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UIComponentCore extends \blaze\web\component\UIComponentBase{

    private $style;
    private $styleClass;
    private $title;
    private $decorator;


    public function getStyle() {
        return $this->getResolvedExpression($this->style);
    }

    public function setStyle($style) {
        $this->style = new \blaze\web\el\Expression($style);
        return $this;
    }

    public function getStyleClass() {
        return $this->getResolvedExpression($this->styleClass);
    }

    public function setStyleClass($styleClass) {
        $this->styleClass = new \blaze\web\el\Expression($styleClass);
        return $this;
    }

    public function getTitle() {
        return $this->getResolvedExpression($this->title);
    }

    public function setTitle($title) {
        $this->title = new \blaze\web\el\Expression($title);
        return $this;
    }

    public function getDecorator() {
        return $this->getResolvedExpression($this->decorator);
    }

    public function setDecorator($decorator) {
        $this->decorator = new \blaze\web\el\Expression($decorator);
        return $this;
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;
        $decoratorName = $this->getDecorator();
        
        if($decoratorName == null){
            parent::processRender($context);
        }else{
            $decorator = $context->getApplication()->getDecorator($decoratorName);
            $decorator->renderBegin($context, $this);
            parent::processRender($context);
            $decorator->renderEnd($context, $this);
        }
    }


}

?>
