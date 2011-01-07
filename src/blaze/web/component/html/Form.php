<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of CommandLink
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Form extends \blaze\web\component\UIForm {

    private $destination;

    public function __construct() {

    }

    public static function create() {
        return new Form();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'FormRenderer';
    }

    public function getDestination() {
        return $this->getResolvedExpression($this->destination);
    }

    public function setDestination($destination) {
        $this->destination = new \blaze\web\el\Expression($destination);
        return $this;
    }

}

?>
