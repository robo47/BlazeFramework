<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of UIOutput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class UIOutput extends \blaze\web\component\UIComponentCore implements ValueHolder {

    /**
     *
     * @var blaze\web\el\ValueExpression
     */
    private $value;
    private $localValue;
    /**
     *
     * @var blaze\web\converter\Converter
     */
    private $converter;

    public function getConverter() {
        return $this->converter;
    }

    public function getLocalValue() {
        return $this->localValue;
    }

    public function setLocalValue($localValue) {
        return $this->localValue = $localValue;
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getValueExpression() {
        return $this->value;
    }

    public function removeConverter() {
        $this->converter = null;
        return $this;
    }

    public function setConverter(\blaze\web\converter\Converter $converter) {
        $this->converter = $converter;
        return $this;
    }

}

?>
