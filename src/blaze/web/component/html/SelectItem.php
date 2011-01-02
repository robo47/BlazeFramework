<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of DataTable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SelectItem extends \blaze\web\component\UIComponentBase{

    private $value;
    private $label;
    private $disabled;

    public function __construct() {

    }

    public static function create() {
        return new SelectItem();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return '';
    }

    public function getLabel() {
        return $this->getResolvedExpression($this->label);
    }

    public function setLabel($label) {
        $this->label = new \blaze\web\el\Expression($label);
        return $this;
    }

    public function getDisabled() {
        return $this->getResolvedExpression($this->disabled);
    }

    public function setDisabled($disabled) {
        $this->disabled = new \blaze\web\el\Expression($disabled);
        return $this;
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }


}

?>
