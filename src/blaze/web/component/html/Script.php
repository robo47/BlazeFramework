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
class Script extends \blaze\web\component\UIComponentBase {

    private $src;

    public function __construct() {

    }

    public static function create() {
        return new Script();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'ScriptRenderer';
    }

    public function getSrc() {
        return $this->getResolvedExpression($this->src);
    }

    public function setSrc($src) {
        $this->src = new \blaze\web\el\Expression($src);
        return $this;
    }

}

?>
