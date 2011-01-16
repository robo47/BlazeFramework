<?php

namespace blaze\web\component;

use blaze\lang\Object;

/**
 * Description of DataTable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
abstract class UIData extends \blaze\web\component\UIComponentCore implements \blaze\web\component\NamingContainer {

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
    private $idCount = 0;

    public function createUniqueId() {
        return $this->getId() . self::ID_SEPARATOR . ($this->idCount++);
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

    public function getSelectedRowLocal() {
        return $this->selectedRow;
    }

    public function setSelectedRow($selectedRow) {
        $this->selectedRow = new \blaze\web\el\Expression($selectedRow);
        return $this;
    }

    public function getSelectedRowIndex() {
        if ($this->selectedRowIndex === null)
            return -1;
        $idx = $this->getResolvedExpression($this->selectedRowIndex);
        return $idx !== null ? $idx : -1;
    }

    public function getSelectedRowIndexLocal() {
        return $this->selectedRowIndex;
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

    protected function getRowChildren(\blaze\web\application\BlazeContext $context) {
        $values = $this->getValue();
        if ($values == null)
            return null;
        foreach ($values as $value) {
            $context->getELContext()->getContext(\blaze\web\el\ELContext::SCOPE_REQUEST)->set($context, $this->getVar(), $value);
        }
    }

}

?>
