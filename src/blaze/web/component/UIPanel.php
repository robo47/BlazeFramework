<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of Address
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class UIPanel extends \blaze\web\component\UIComponentCore implements \blaze\web\component\NamingContainer {

    public function __construct() {

    }

    public static function create() {
        return new Panel();
    }

}

?>
