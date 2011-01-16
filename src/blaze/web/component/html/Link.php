<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Link
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Link extends \blaze\web\component\UIComponentCore {

    private $value;
    private $href;
    private $rel;
    private $target;

    public function __construct() {

    }

    public static function create() {
        return new Link();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'LinkRenderer';
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getHref() {
        return $this->getResolvedExpression($this->href);
    }

    public function setHref($href) {
        $this->href = new \blaze\web\el\Expression($href);
        return $this;
    }

    public function getRel() {
        return $this->getResolvedExpression($this->rel);
    }

    public function setRel($rel) {
        $this->rel = new \blaze\web\el\Expression($rel);
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
