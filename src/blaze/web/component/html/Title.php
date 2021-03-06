<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Title
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Title extends \blaze\web\component\UIComponentBase {

    private $value;

    public function __construct() {

    }

    public static function create() {
        return new Title();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'TitleRenderer';
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
