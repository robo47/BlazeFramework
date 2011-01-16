<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Head
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Messages extends \blaze\web\component\UIComponentCore {

    private $for;

    public function __construct() {

    }

    public static function create() {
        return new Messages();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'MessagesRenderer';
    }

    public function getFor() {
        return $this->getResolvedExpression($this->for);
    }

    public function setFor($for) {
        $this->for = new \blaze\web\el\Expression($for);
        return $this;
    }

}

?>
