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
abstract class UICommand extends \blaze\web\component\UIComponentBase implements ActionSource {

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
    private $actionListener;


//    public function getImmediate() {
//        return $this->getResolvedExpression($this->immediate);
//    }
//
//    public function setImmediate($immediate) {
//        $this->immediate = new \blaze\web\el\Expression($immediate);
//        return $this;
//    }

    public function getAction() {
        return $this->invokeResolvedExpression($this->action);
    }

    public function setAction($action) {
        $this->action = new \blaze\web\el\Expression($action);
        return $this;
    }
    public function getActionListener() {
        return $this->invokeResolvedExpression($this->actionListener);
    }

    public function setActionListener($actionListener) {
        $this->actionListener = new \blaze\web\el\Expression($actionListener);
        return $this;
    }

    public function processApplication(\blaze\web\application\BlazeContext $context) {
        parent::processApplication($context);
        $actionListener = $this->getActionListener();
        $action = $this->getAction();
        $navigationString = null;

        if($actionListener != null)
            $this->invokeResolvedExpression($actionListener);
        if($action != null){
            if($action instanceof \blaze\web\el\Expression)
                $navigationString = $this->invokeResolvedExpression($action);
            else
                $navigationString = $action;
        }
        if($navigationString != null)
            $context->getApplication()->getNavigationHandler()->navigate($context, $navigationString);
    }


}
?>
