<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Address
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Address extends \blaze\web\component\UIPanel {

    public function __construct() {

    }

    public static function create() {
        return new Address();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'AddressRenderer';
    }

}

?>
