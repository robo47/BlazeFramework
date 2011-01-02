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
class Head extends \blaze\web\component\UIComponentBase {

    public function __construct() {

    }

    public static function create() {
        return new Head();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'HeadRenderer';
    }

}
?>
