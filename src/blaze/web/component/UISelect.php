<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of UIInput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UISelect extends \blaze\web\component\UIInput {

    private $items = array();
    private $idField;


    public function addChild(\blaze\web\component\UIComponent $child) {
        if ($child instanceof html\SelectItem || $child instanceof html\SelectItems) {
            $this->items[] = $child->setParent($this);
            return $this;
        }else{
            // Not possible because of XSD
            //return parent::addChild($child);
            throw new \blaze\lang\IllegalArgumentException();
        }
    }

    public function getItems() {
        return $this->items;
    }

    public function getIdField() {
        return $this->getResolvedExpression($this->idField);
    }

    public function setIdField($idField) {
        $this->idField = new \blaze\web\el\Expression($idField);
        return $this;
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;
        foreach ($this->getChildren() as $child)
            $child->processUpdates($context);

        try {
            if (!$this->getValid())
                return;
            $valExpr = $this->getValueExpression();

            if ($valExpr == null)
                return;
            $listeners = $this->getValueChangeListeners();
            $newVal = $this->getLocalValue();

//            if (count($listeners) > 0) {
//                $oldVal = $valExpr->getValue($context);
//
//                if ($this->compareEqual($localVal, $newVal)) {
//                    $event = new \blaze\web\event\ValueChangeEvent($this, $oldValue, $newValue);
//
//                    foreach ($listeners as $listener) {
//                        $listener->process($event);
//                    }
//                }
//            }
//            $valExpr->setValue($context, $newVal);
            $obj = $valExpr->getValue($context);
            $obj->getClass()->getMethod('set'.ucfirst($this->getIdField()))->invoke($obj, $newVal);
        } catch (\blaze\lang\Exception $e) {
            $context->renderResponse();
            throw $e;
        }
    }

}

?>
