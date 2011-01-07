<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Image
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Image extends \blaze\web\component\UIComponentCore {

    private $alt;
    private $src;
    private $height;
    private $width;
    private $useMap = false;

    public function addChild(\blaze\web\component\UIComponent $child) {
        if (!$this->useMap && $child instanceof Area)
            $this->useMap = true;
        return parent::addChild($child);
    }

    public function getUseMap() {
        return $this->useMap;
    }

    public function __construct() {

    }

    public static function create() {
        return new Image();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'ImageRenderer';
    }

    public function getAlt() {
        return $this->getResolvedExpression($this->alt);
    }

    public function setAlt($alt) {
        $this->alt = new \blaze\web\el\Expression($alt);
        return $this;
    }

    public function getSrc() {
        return $this->getResolvedExpression($this->src);
    }

    public function setSrc($src) {
        $this->src = new \blaze\web\el\Expression($src);
        return $this;
    }

    public function getHeight() {
        return $this->getResolvedExpression($this->height);
    }

    public function setHeight($height) {
        $this->height = new \blaze\web\el\Expression($height);
        return $this;
    }

    public function getWidth() {
        return $this->getResolvedExpression($this->width);
    }

    public function setWidth($width) {
        $this->width = new \blaze\web\el\Expression($width);
        return $this;
    }

}

?>
