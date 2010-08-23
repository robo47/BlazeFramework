<?php
namespace blaze\web\component;
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
abstract class UIData extends \blaze\web\component\UIComponentCore implements \blaze\web\component\NamingContainer{

    private $rowVar;
    private $rowIndexVar;
    private $rowIdentifier;
    private $value;
    private $selectedRow;
    private $selectedRowIndex;
    private $selectedRowClass;
    private $selectedRowStyle;
    private $rowClasses;
    private $rows;

    private $localRows;
    private $localRowId;
    private $idCount = 0;

    public function createUniqueId(){
        return $this->getId().self::ID_SEPARATOR.($this->idCount++);
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getRowIdentifier() {
        return $this->getResolvedExpression($this->rowIdentifier);
    }

    public function setRowIdentifier($rowIdentifier) {
        $this->rowIdentifier = new \blaze\web\el\Expression($rowIdentifier);
        return $this;
    }

    public function getSelectedRow() {
        return $this->getResolvedExpression($this->selectedRow);
    }

    public function setSelectedRow($selectedRow) {
        $this->selectedRow = new \blaze\web\el\Expression($selectedRow);
        return $this;
    }

    public function getSelectedRowIndex() {
        return $this->getResolvedExpression($this->selectedRowIndex);
    }

    public function setSelectedRowIndex($selectedRowIndex) {
        $this->selectedRowIndex = new \blaze\web\el\Expression($selectedRowIndex);
        return $this;
    }

    public function getSelectedRowClass() {
        return $this->getResolvedExpression($this->selectedRowClass);
    }

    public function setSelectedRowClass($selectedRowClass) {
        $this->selectedRowClass = new \blaze\web\el\Expression($selectedRowClass);
        return $this;
    }

    public function getSelectedRowStyle() {
        return $this->getResolvedExpression($this->selectedRowStyle);
    }

    public function setSelectedRowStyle($selectedRowStyle) {
        $this->selectedRowStyle = new \blaze\web\el\Expression($selectedRowStyle);
        return $this;
    }

    public function getRowVar() {
        return $this->rowVar;
    }

    public function setRowVar($rowVar) {
        $this->rowVar = $rowVar;
        return $this;
    }

    public function getRowIndexVar() {
        return $this->rowIndexVar;
    }

    public function setRowIndexVar($rowIndexVar) {
        $this->rowIndexVar = $rowIndexVar;
        return $this;
    }

    public function getRowClasses() {
        return $this->getResolvedExpression($this->rowClasses);
    }

    public function setRowClasses($rowClasses) {
        $this->rowClasses = new \blaze\web\el\Expression($rowClasses);
        return $this;
    }

    public function getRows() {
        return $this->getResolvedExpression($this->rows);
    }

    public function setRows($rows) {
        $this->rows = new \blaze\web\el\Expression($rows);
        return $this;
    }

//    public function processDecodes(\blaze\web\application\BlazeContext $context) {
//        if(!$this->getRendered())
//                return;
//        $prefix = $this->getId().self::CONTAINER_SEPARATOR;
//        $map = $context->getRequest()->getParameterMap();
//        foreach($map as $key => $value){
//            $map->getKey()
//        }
//    }

    protected function getRowChildren(\blaze\web\application\BlazeContext $context){
        $values = $this->getValue();
        if($values == null)
            return null;
        foreach($values as $value){
            $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $this->getVar(), $value);

        }
    }

}

?>
