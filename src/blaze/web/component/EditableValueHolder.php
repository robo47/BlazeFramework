<?php
namespace blaze\web\component;

/**
 * Description of EditableValueHolder
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface EditableValueHolder extends ValueHolder {
     public function getSubmittedValue();
     public function setSubmittedValue($submittedValue);
     public function getRequired();
     public function setRequired($required);
     public function getImmediate();
     public function setImmediate($immediate);
     
     public function addValidator(\blaze\web\validator\Validator $validator);
     public function setValidator($validator);
     /**
      * @return blaze\web\validator\Validator
      */
     public function getValidators();
     public function removeValidator(\blaze\web\validator\Validator $validator);
     
     public function getValid();
     public function setValid($valid);

     public function addValueChangeListener(\blaze\web\el\Expression $validator);
     public function setValueChangeListener($validator);
     /**
      * @return blaze\web\event\ValueChangeListener
      */
     public function getValueChangeListeners();
     //public function removeValueChangeListener(\blaze\web\event\ValueChangeListener $validator);
}

?>
