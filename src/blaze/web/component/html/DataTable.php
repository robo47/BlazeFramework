<?php

namespace blaze\web\component\html;

use blaze\lang\Object;

/**
 * Description of DataTable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
    private $idCount = 0;

    public function addChild(\blaze\web\component\UIComponent $child) {
        if ($child instanceof DataTableColumn) {
            $this->columns[] = $child->setParent($this);
            return $this;
        } else {
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

    public function getContainerPrefix() {
        return 'table';
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

    public function createUniqueId(){
        return $this->getId().self::CONTAINER_SEPARATOR.$this->rowId.self::ID_SEPARATOR.($this->idCount++);
    }

    public function processDecodes(\blaze\web\application\BlazeContext $context) {
        if(!$this->getRendered())
                return;
        $values = $this->getValue();
        if($values == null)
            return null;

        $this->rowId = 0;

        foreach($values as $value){
            $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $this->getRowVar(), $value);
            foreach($this->columns as $column){
                $column->processDecodes($context);
            }
            $this->rowId++;
        }

        $this->rowId = -1;
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        if(!$this->getRendered())
                return;
        $values = $this->getValue();
        if($values == null)
            return null;

        $this->rowId = 0;

        foreach($values as $value){
            $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $this->getRowVar(), $value);
            foreach($this->columns as $column){
                $column->processRender($context);
            }
            $this->rowId++;
        }

        $this->rowId = -1;
    }

}

?>
