<?php
namespace blaze\web\component;

/**
 * Description of ValueHolder
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ValueHolder {
     public function getLocalValue();
     public function setLocalValue($localValue);
     public function getValueExpression();
     public function getValue();
     public function setValue($value);
     public function setConverter(\blaze\web\converter\Converter $converter);
     /**
      * @return blaze\web\converter\Converter
      */
     public function getConverter();
     public function removeConverter();
}

?>
