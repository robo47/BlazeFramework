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
abstract class UIInput extends \blaze\web\component\UIOutput implements EditableValueHolder {

    private $validators = array();
    private $valueChangeListeners = array();
    /**
     *
     * @var blaze\web\el\Expression
     */
    private $immediate;
    /**
     *
     * @var blaze\web\el\Expression
     */
    private $required;
    private $valid = true;
    private $submittedValue;

    public function addChild(\blaze\web\component\UIComponent $child) {
        if ($child)
            parent::addChild($child);
    }

    public function addValidator(\blaze\web\validator\Validator $validator) {
        $this->validators[] = $validator;
    }

    public function addValueChangeListener(\blaze\web\el\Expression $valueChangeListener) {
        $this->valueChangeListeners[] = new \blaze\web\event\ExpressionValueChangeListener($valueChangeListener);
    }

    public function getImmediate() {
        if ($this->immediate == null)
            return false;
        return $this->getResolvedExpression($this->immediate);
    }

    public function getRequired() {
        if ($this->required == null)
            return false;
        return $this->getResolvedExpression($this->required);
    }

    public function getValueChangeListeners() {
        return $this->valueChangeListeners;
    }

    public function getSubmittedValue() {
        return $this->submittedValue;
    }

    public function getValidators() {
        return $this->validators;
    }

    public function removeValidator(\blaze\web\validator\Validator $validator) {
        $keyLocal = null;
        foreach ($this->validators as $key => $validatorLocal) {
            if ($validatorLocal == $validator) {
                $keyLocal = $key;
                break;
            }
        }

        if ($keyLocal != null)
            unset($this->validators[$keyLocal]);
        return $this;
    }

    public function setImmediate($immediate) {
        $this->immediate = new \blaze\web\el\Expression($immediate);
        return $this;
    }

    public function setRequired($required) {
        $this->required = new \blaze\web\el\Expression($required);
        return $this;
    }

    public function setSubmittedValue($submittedValue) {
        $this->submittedValue = $submittedValue;
        return $this;
    }

    public function getValid() {
        return $this->valid;
    }

    public function setValid($valid) {
        $this->valid = $valid;
    }

    public function setValidator($validator) {
        $this->addValidator(new \blaze\web\el\Expression($validator));
        return $this;
    }

    public function setValueChangeListener($valueChangeListener) {
        $this->addValueChangeListener(new \blaze\web\el\Expression($valueChangeListener));
        return $this;
    }

    /**
     *
     * @todo think about what to do with immediate
     */
    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;
        parent::processDecodes($context);
        // Immediate?
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;
        parent::processUpdates($context);

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
            $valExpr->setValue($context, $newVal);
        } catch (\blaze\lang\Exception $e) {
            $context->renderResponse();
            throw $e;
        }
    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;
        parent::processValidations($context);

        if (!$this->getImmediate()) {
            try {
                $convertedValue = $this->submittedValue;
                $converter = $this->getConverter();

                if ($converter != null)
                    $convertedValue = $converter->asObject($context, $this->submittedValue);

                foreach ($this->validators as $validator)
                    $validator->validate($context, $convertedValue);

                $this->setLocalValue($convertedValue);
                return;
            } catch (blaze\web\converter\ConverterException $ce) {
                $this->setValid(false);
                $context->addMessage($this->getId(), new \blaze\web\application\BlazeMessage($ce->getMessage()));
            } catch (blaze\web\converter\ValidatorException $ve) {
                $this->setValid(false);
                $context->addMessage($this->getId(), new \blaze\web\application\BlazeMessage($ce->getMessage()));
            } catch (\blaze\lang\Exception $e) {
                $this->setValid(false);
                throw $e;
            }
            $context->renderResponse();
        }
    }

}

?>
