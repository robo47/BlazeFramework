<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of UICommand
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UICommand extends \blaze\web\component\UIComponentCore implements ActionSource {

//    /**
//     *
//     * @var blaze\web\el\Expression
//     */
//    private $immediate = false;
    /**
     *
     * @var blaze\web\el\Expression
     */
    private $action;
    /**
     *
     * @var blaze\web\el\Expression
     */
    private $actionListeners = array();
    private $cachedActionEvent;

//    public function getImmediate() {
//        return $this->getResolvedExpression($this->immediate);
//    }
//
//    public function setImmediate($immediate) {
//        $this->immediate = new \blaze\web\el\Expression($immediate);
//        return $this;
//    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = new \blaze\web\el\Expression($action);
        return $this;
    }

    public function addActionListener(\blaze\web\el\Expression $expression) {
        if ($this->cachedActionEvent == null)
            $this->cachedActionEvent = new \blaze\web\event\ActionEvent($this);
        $this->actionListeners[] = new \blaze\web\event\ExpressionActionListener($expression);
    }

    public function getActionListeners() {
        return $this->actionListeners;
    }

    public function setActionListener($actionListener) {
        $this->addActionListener(new \blaze\web\el\Expression($actionListener));
        return $this;
    }

    public function processApplication(\blaze\web\application\BlazeContext $context) {
        parent::processApplication($context);
        $actionListeners = $this->getActionListeners();
        $action = $this->getAction();
        $navigationString = null;

        foreach ($actionListeners as $listener)
            $listener->processAction($this->cachedActionEvent);
        if ($action != null)
            $navigationString = $this->invokeResolvedExpression($action);

        if ($navigationString != null)
            $context->getApplication()->getNavigationHandler()->navigate($context, $navigationString);
    }

}

?>
