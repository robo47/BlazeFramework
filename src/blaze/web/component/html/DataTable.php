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
class DataTable extends \blaze\web\component\UIComponentCore{

    private $summary;
    private $value;
    private $rows;
    private $var;
    private $columns = array();
    
    // Caption-tag
    private $caption;
    private $captionStyle;
    private $captionClass;

    private $columnClasses;
    private $rowClasses;

    public function addChild(\blaze\web\component\UIComponent $child) {
        if($child instanceof DataTableColumn){
            $this->columns[] = $child;
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

    public function __construct(){
    }

    public static function create(){
        return new DataTable();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'DataTableRenderer';
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getSummary() {
        return $this->getResolvedExpression($this->summary);
    }

    public function setSummary($summary) {
        $this->summary = new \blaze\web\el\Expression($summary);
        return $this;
    }

    public function getRows() {
        return $this->getResolvedExpression($this->rows);
    }

    public function setRows($rows) {
        $this->rows = new \blaze\web\el\Expression($rows);
        return $this;
    }

    public function getVar() {
        return $this->getResolvedExpression($this->var);
    }

    public function setVar($var) {
        $this->var = new \blaze\web\el\Expression($var);
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

    public function getRowClasses() {
        return $this->getResolvedExpression($this->rowClasses);
    }

    public function setRowClasses($rowClasses) {
        $this->rowClasses = new \blaze\web\el\Expression($rowClasses);
        return $this;
    }

}

?>
