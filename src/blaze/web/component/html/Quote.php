<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Quote
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Quote extends \blaze\web\component\UIComponentCore {

    private $cite;
    private $block;

    public function __construct() {

    }

    public static function create() {
        return new Quote();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'QuoteRenderer';
    }

    public function getCite() {
        return $this->getResolvedExpression($this->cite);
    }

    public function setCite($cite) {
        $this->cite = new \blaze\web\el\Expression($cite);
        return $this;
    }

    public function getBlock() {
        if ($this->block == null)
            return true;
        return $this->getResolvedExpression($this->block);
    }

    public function setBlock($block) {
        $this->block = new \blaze\web\el\Expression($block);
        return $this;
    }

}

?>
