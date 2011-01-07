<?php

namespace blaze\web\component;

/**
 * Description of UIComponent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface UIComponent {

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getClientId(\blaze\web\application\BlazeContext $context);

    /**
     * @param string|blaze\lang\String $id
     * @return blaze\web\component\UIComponent
     */
    public function setId($id);

    /**
     * @return blaze\web\component\UIComponent
     */
    public function getParent();

    /**
     * @param blaze\web\component\UIComponent $parent
     * @return blaze\web\component\UIComponent
     */
    public function setParent(\blaze\web\component\UIComponent $parent);

    /**
     * @return array
     */
    public function getChildren();

    /**
     * @param blaze\web\component\UIComponent $child
     * @return blaze\web\component\UIComponent
     */
    public function addChild(\blaze\web\component\UIComponent $child);

    /**
     * @return boolean
     */
    public function getRendered();

    /**
     * @param boolean $rendered
     * @return blaze\web\component\UIComponent
     */
    public function setRendered($rendered);

    public static function create();

    public function queueEvent(\blaze\web\event\BlazeEvent $event);

    /**
     * @return blaze\web\render\Renderer
     */
    public function getRenderer(\blaze\web\application\BlazeContext $context);

    public function getRendererId();

    public function getComponentFamily();

    public function processEvent(\blaze\web\application\BlazeContext $context, \blaze\web\event\BlazeEvent $event);

    public function processDecodes(\blaze\web\application\BlazeContext $context);

    public function processValidations(\blaze\web\application\BlazeContext $context);

    public function processUpdates(\blaze\web\application\BlazeContext $context);

    public function processApplication(\blaze\web\application\BlazeContext $context, \blaze\web\event\ActionEvent $event);

    public function processRender(\blaze\web\application\BlazeContext $context);
}

?>
