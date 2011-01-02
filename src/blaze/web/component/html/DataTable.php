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
class DataTable extends \blaze\web\component\UIData {

    private $summary;
    private $columns = array();
    // Caption-tag
    private $caption;
    private $captionStyle;
    private $captionClass;
    private $columnClasses;
    private $rowId = -1;

    public function addChild(\blaze\web\component\UIComponent $child) {
        if ($child instanceof DataTableColumn || $child instanceof DataTableColumns) {
            $this->columns[] = $child->setParent($this);
            return $this;
        }else{
            // Not possible because of XSD
            //return parent::addChild($child);
            throw new \blaze\lang\IllegalArgumentException();
        }
    }

    public function getColumns() {
        return $this->columns;
    }

    public function __construct() {

    }

    public static function create() {
        return new DataTable();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'DataTableRenderer';
    }

    public function getSummary() {
        return $this->getResolvedExpression($this->summary);
    }

    public function setSummary($summary) {
        $this->summary = new \blaze\web\el\Expression($summary);
        return $this;
    }

    public function getCaption() {
        return $this->getResolvedExpression($this->caption);
    }

    public function setCaption($caption) {
        $this->caption = new \blaze\web\el\Expression($caption);
        return $this;
    }

    public function getCaptionStyle() {
        return $this->getResolvedExpression($this->captionStyle);
    }

    public function setCaptionStyle($captionStyle) {
        $this->captionStyle = new \blaze\web\el\Expression($captionStyle);
        return $this;
    }

    public function getCaptionClass() {
        return $this->getResolvedExpression($this->captionClass);
    }

    public function setCaptionClass($captionClass) {
        $this->captionClass = new \blaze\web\el\Expression($captionClass);
        return $this;
    }

    public function getColumnClasses() {
        return $this->getResolvedExpression($this->columnClasses);
    }

    public function setColumnClasses($columnClasses) {
        $this->columnClasses = new \blaze\web\el\Expression($columnClasses);
        return $this;
    }

    public function getClientId(\blaze\web\application\BlazeContext $context) {
        $clientId = parent::getClientId($context);
        if ($this->rowId == -1)
            return $clientId;
        else
            return $clientId . self::CONTAINER_SEPARATOR . $this->rowId;
    }

    public function getRowId() {
        return $this->rowId;
    }

    public function setRowId($rowId) {
        $this->rowId = $rowId;
    }
}

?>
