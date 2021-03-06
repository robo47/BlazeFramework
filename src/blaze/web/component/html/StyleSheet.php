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
class StyleSheet extends \blaze\web\component\UIComponentBase {

    private $href;
    private $charset;

    public function __construct() {

    }

    public static function create() {
        return new StyleSheet();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'StyleSheetRenderer';
    }

    public function getHref() {
        return $this->getResolvedExpression($this->href);
    }

    public function setHref($href) {
        $this->href = new \blaze\web\el\Expression($href);
        return $this;
    }

    public function getCharset() {
        return $this->getResolvedExpression($this->charset);
    }

    public function setCharset($charset) {
        $this->charset = new \blaze\web\el\Expression($charset);
        return $this;
    }

}

?>
