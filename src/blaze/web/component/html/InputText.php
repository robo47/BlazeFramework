<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of InputText
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class InputText extends \blaze\web\component\UIInput {

    public function __construct() {

    }

    public static function create() {
        return new InputText();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'InputTextRenderer';
    }

    public function getType() {
        return 'text';
    }

}

?>
