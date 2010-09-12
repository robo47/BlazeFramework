<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of DataTableColumn
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class DataTableColumn extends \blaze\web\component\UIComponentCore {

    private $header;
    private $footer;

    public function addChild(\blaze\web\component\UIComponent $child) {
        if ($this->header == null && $child instanceof DataTableHeader) {
            return $this->header = $child->setParent($this);
        } else if ($this->footer == null && $child instanceof DataTableFooter) {
            return $this->footer = $child->setParent($this);
        } else {
            return parent::addChild($child);
        }
    }
    public function getHeader() {
        return $this->header;
    }

    public function getFooter() {
        return $this->footer;
    }

    public function hasHeader() {
        return $this->header != null;
    }

    public function hasFooter() {
        return $this->footer != null;
    }

    public function __construct() {

    }

    public static function create() {
        return new DataTableColumn();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return '';
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        foreach ($this->getChildren() as $child) {
            $child->processDecodes($context);
        }
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        foreach ($this->getChildren() as $child) {
            $child->processRender($context);
        }
    }

}

?>
