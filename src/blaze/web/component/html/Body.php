<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Body
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Body extends \blaze\web\component\UIComponentBase {

    public function __construct() {

    }

    public static function create() {
        return new Body();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'BodyRenderer';
    }

}

?>
