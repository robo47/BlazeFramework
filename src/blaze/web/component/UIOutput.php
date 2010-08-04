<?php
namespace blaze\web\component;
use blaze\lang\Object;

/**
 * Description of UIOutput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class UIOutput extends \blaze\web\component\UIComponentCore implements ValueHolder{

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

    public function getValue(){
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

    public function setLocalValue($localValue) {
        $this->localValue = $localValue;
        return $this;
    }

    public function setValue($value) {
        if(\blaze\web\el\Expression::isExpression($value))
            $this->value = new \blaze\web\el\Expression($value);
        else
            $this->localValue = $value;
        return $this;
    }

}

?>
