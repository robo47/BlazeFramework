<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of UIOutput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class OutputText extends \blaze\web\component\UIOutput {

    /**
     * - p -> default
     * - b
     * - em
     * - strong
     * - dfn
     * - code
     * - samp
     * - kbd
     * - var
     * - cite
     * - none
     * - h1-h6
     */
    private $type;

    public function __construct() {

    }

    public static function create() {
        return new OutputText();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'OutputTextRenderer';
    }

    public function getType() {
        return $this->getResolvedExpression($this->type);
    }

    public function setType($type) {
        $this->type = new \blaze\web\el\Expression($type);
        return $this;
    }

}

?>
