<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Base
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Base extends \blaze\web\component\UIComponentBase {

    private $href;
    private $target;

    public function __construct() {

    }

    public static function create() {
        return new Base();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'BaseRenderer';
    }

    public function getHref() {
        return $this->getResolvedExpression($this->href);
    }

    public function setHref($href) {
        $this->href = new \blaze\web\el\Expression($href);
        return $this;
    }

    public function getTarget() {
        return $this->getResolvedExpression($this->target);
    }

    public function setTarget($target) {
        $this->target = new \blaze\web\el\Expression($target);
        return $this;
    }

}

?>
