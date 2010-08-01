<?php
namespace blaze\web\component;

/**
 * Description of ValueHolder
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface ValueHolder {
     public function getLocalValue();
     public function setLocalValue($localValue);
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
