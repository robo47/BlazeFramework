<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of ContentLanguage
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ContentLanguage extends \blaze\web\component\UIComponentBase {

    private $value;

    public function __construct() {

    }

    public static function create() {
        return new ContentLanguage();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'MetaRenderer';
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
