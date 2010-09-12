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
    /**
     *
     * @var blaze\web\el\Expression
     */
    private $requiredMessage;
    private $label;
    private $disabled;
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
        if ($this->immediate === null)
            return false;
        $imm = $this->getResolvedExpression($this->immediate);
        return \blaze\lang\Boolean::isType($imm) ? $imm : \blaze\lang\String::asWrapper($imm)->trim()->compareToIgnoreCase('true') == 0;
    }

    public function getRequired() {
        if ($this->required === null)
            return false;
        $requ = $this->getResolvedExpression($this->required);
        return \blaze\lang\Boolean::isType($requ) ? $requ : \blaze\lang\String::asWrapper($requ)->trim()->compareToIgnoreCase('true') == 0;
    }

    public function getRequiredMessage() {
        return $this->getResolvedExpression($this->requiredMessage);
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

    public function setRequiredMessage($requiredMessage) {
        $this->requiredMessage = new \blaze\web\el\Expression($requiredMessage);
        return $this;
    }

    public function setSubmittedValue($submittedValue) {
        $this->submittedValue = $submittedValue;
        return $this;
    }

    public function getLabel() {
        return $this->getResolvedExpression($this->label);
    }

    public function setLabel($label) {
        $this->label = new \blaze\web\el\Expression($label);
        return $this;
    }

    public function getDisabled() {
        if ($this->disabled === null)
            return false;
        $disabled = $this->getResolvedExpression($this->disabled);
        return \blaze\lang\Boolean::isType($disabled) ? $disabled : \blaze\lang\String::asWrapper($disabled)->trim()->compareToIgnoreCase('true') == 0;
    }

    public function setDisabled($disabled) {
        $this->disabled = new \blaze\web\el\Expression($disabled);
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
        if($this->getImmediate()){
            $this->validate($context);
        }
        parent::processDecodes($context);
    }

    public function processUpdates(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;

        $ex = null;

        try {
            if (!$this->getValid())
                return;
            $valExpr = $this->getValueExpression();

            if ($valExpr == null)
                return;
            $listeners = $this->getValueChangeListeners();
            $newVal = $this->getLocalValue();

            if (count($listeners) > 0) {
                $oldVal = $valExpr->getValue($context);

                if ($this->compare($oldVal, $newVal)) {
                    $event = new \blaze\web\event\ValueChangeEvent($this, $oldValue, $newValue);
                    $this->queueEvent($event);
                }
            }
            $valExpr->setValue($context, $newVal);
        } catch (\blaze\lang\Exception $e) {
            $context->renderResponse();
            $ex = $e;
        }

        parent::processUpdates($context);
        if($ex != null)
            throw $ex;
    }

    private function compare($old, $new){
        if($old instanceof Object && $new instanceof Object)
            return $old->equals($new);
        else
            return $old == $new;
    }

    public function processValidations(\blaze\web\application\BlazeContext $context) {
        if (!$this->getRendered())
            return;

        $ex = null;
        if (!$this->getImmediate()) {
            try{
                $this->validate($context);
            }catch(blaze\lang\Exception $e){
                $context->renderResponse();
            $ex = $e;
            }
            if(!$this->getValid()){
                  $context->renderResponse();
            }
        }

        parent::processValidations($context);
        if($ex != null)
            throw $ex;
    }

    protected function validate(\blaze\web\application\BlazeContext $context){
        try {
            $requMsg = $this->getRequiredMessage();
            if($this->getRequired() === true && ($this->submittedValue === null || strlen($this->submittedValue) == 0))
                    throw new \blaze\web\validator\ValidatorException(new \blaze\web\application\BlazeMessage( $requMsg !== null ? $requMsg : $this->getClientId($context).' is required!'));

            $convertedValue = $this->submittedValue;
            $converter = $this->getConverter();

            if ($converter != null)
                $convertedValue = $converter->asObject($context, $this->submittedValue);

            foreach ($this->validators as $validator)
                $validator->validate($context, $convertedValue);

            $this->setLocalValue($convertedValue);
            $this->setValid(true);
            return;
        } catch (\blaze\web\converter\ConverterException $ce) {
            $this->setValid(false);
            $context->addMessage($this->getId(), $ce->getBlazeMessage());
        } catch (\blaze\web\validator\ValidatorException $ve) {
            $this->setValid(false);
            $context->addMessage($this->getId(), $ve->getBlazeMessage());
        } catch (\blaze\lang\Exception $e) {
            $this->setValid(false);
            throw $e;
        }
    }

}

?>
