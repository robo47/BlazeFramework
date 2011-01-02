<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of DataTableColumn
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class DataListRow extends \blaze\web\component\UIComponentCore {

    public function __construct() {

    }

    public static function create() {
        return new DataListRow();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'DataListRowRenderer';
    }


}
?>
