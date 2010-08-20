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
    /**
     *
     * @var blaze\web\el\Expression
     */
    private $immediate;
    /**
     *
     * @var blaze\web\el\Expression
     */
    private $required = false;
    private $valid = true;
    private $submittedValue;

    public function addValidator(\blaze\web\validator\Validator $validator) {
        $this->validators[] = $validator;
        return $this;
    }

    public function getImmediate() {
        if($this->immediate == null)
                return false;
        return $this->getResolvedExpression($this->immediate);
    }

    public function getRequired() {
        return $this->getResolvedExpression($this->required);
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

        try{
            if(!$this->getValid())
                    return;
            $valExpr = $this->getValueExpression();

            if($valExpr == null)
                return;

            $valExpr->setValue($context, $this->getLocalValue());
        }catch(\blaze\lang\Exception $e){
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

                // Maybe for valueChangeListener
                //$previousVal = $this->getValue();

                $this->setLocalValue($convertedValue);
            } catch (blaze\web\converter\ConverterException $ce) {
                $this->setValid(false);
                $context->addMessage($this->getId(), new \blaze\web\application\BlazeMessage($ce->getMessage()));
            } catch (blaze\web\converter\ValidatorException $ve) {
                $this->setValid(false);
                $context->addMessage($this->getId(), new \blaze\web\application\BlazeMessage($ce->getMessage()));
            } catch (\blaze\lang\Exception $e) {
                $this->setValid(false);
                $context->renderResponse();
                throw $e;
            }
        }
    }

}
?>
