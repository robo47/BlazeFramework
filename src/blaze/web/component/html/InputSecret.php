<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of InputSecret
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class InputSecret extends InputText {

    public function __construct() {

    }

    public static function create() {
        return new InputSecret();
    }

    public function getType() {
        return 'password';
    }

}

?>
