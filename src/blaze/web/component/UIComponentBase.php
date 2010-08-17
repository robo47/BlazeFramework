<?php

namespace blaze\web\component;

/**
 * Description of UIComponentBase
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UIComponentBase extends \blaze\lang\Object implements UIComponent {

    private $id;
    private $parent;
    private $children = array();
    private $rendered;

    public function getChildren() {
        return $this->children;
    }

    public function addChild(\blaze\web\component\UIComponent $child) {
        $this->children[] = $child->setParent($this);
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent(\blaze\web\component\UIComponent $parent) {
        $this->parent = $parent;
        return $this;
    }

    public function getRendered() {
        return $this->rendered;
    }

    public function setRendered($rendered) {
        $this->rendered = $rendered;
        return $this;
    }

    protected function getResolvedExpression(\blaze\web\el\Expression $expr = null){
        if($expr == null)
            return null;
        if(!$expr->isValid())
                return $expr->getExpressionString();
        $context = \blaze\web\application\BlazeContext::getCurrentInstance();
        return $expr->getValue($context);
    }

    protected function invokeResolvedExpression(\blaze\web\el\Expression $expr = null){
        if($expr == null)
            return null;
        if(!$expr->isValid())
                return $expr->getExpressionString();
        $context = \blaze\web\application\BlazeContext::getCurrentInstance();
        return $expr->invoke($context, array());
    }

    /**
     * @return blaze\web\render\Renderer
     */
    public function getRenderer(\blaze\web\application\BlazeContext $context) {
        return $context->getApplication()
                ->getRenderKitFactory($this->getComponentFamily())
                ->getRenderKit($context, $this->getComponentFamily())
                ->getRenderer($this->getRendererId());
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        $renderer = $this->getRenderer($context);
        $renderer->decode($context, $this);

        foreach ($this->children as $child)
            $child->processDecodes($context);
    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {
        foreach ($this->children as $child)
            $child->processValidations($context);
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        foreach ($this->children as $child)
            $child->processUpdates($context);
    }

    public function processApplication(\blaze\web\application\BlazeContext $context) {
        foreach ($this->children as $child)
            $child->processApplication($context);
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        if ($this->rendered)
            return;
        $renderer = $this->getRenderer($context);

        $renderer->renderBegin($context, $this);
        $renderer->renderAttributes($context, $this);
        $renderer->renderChildren($context, $this);
        $renderer->renderEnd($context, $this);
    }

}
?>
