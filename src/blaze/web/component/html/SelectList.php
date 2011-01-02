<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of DataTable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class SelectList extends \blaze\web\component\UISelect{

    private $type;
    private $size;

    public function __construct() {

    }

    public static function create() {
        return new SelectList();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'SelectListRenderer';
    }

    public function getType() {
        return $this->getResolvedExpression($this->type);
    }

    public function setType($type) {
        $this->type = new \blaze\web\el\Expression($type);
        return $this;
    }

    public function getSize() {
        return $this->getResolvedExpression($this->size);
    }

    public function setSize($size) {
        $this->size = new \blaze\web\el\Expression($size);
        return $this;
    }

}

?>
