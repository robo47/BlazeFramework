<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of DataTableFooter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class DataTableFooter extends \blaze\web\component\UIComponentCore {

    private $span;

    public function __construct() {

    }

    public static function create() {
        return new DataTableFooter();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return '';
    }

    public function getSpan() {
        return $this->getResolvedExpression($this->span);
    }

    public function setSpan($span) {
        $this->span = new \blaze\web\el\Expression($span);
        return $this;
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        foreach ($this->getChildren() as $child) {
            $child->processRender($context);
        }
    }

}

?>
