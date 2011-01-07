<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of Article
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Article extends \blaze\web\component\UIPanel {

    public function __construct() {

    }

    public static function create() {
        return new Article();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'PanelRenderer';
    }

    public function getType() {
        return 'div';
    }

}

?>
