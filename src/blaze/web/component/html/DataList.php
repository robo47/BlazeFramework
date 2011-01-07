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
class DataList extends \blaze\web\component\UIComponentCore implements \blaze\web\component\NamingContainer {

    private $value;
    private $var;
    private $rows = array();
    private $rowClasses;
    private $rowId = -1;
    private $idCount = 0;

    public function addChild(\blaze\web\component\UIComponent $child) {
        return parent::addChild($child);
//        if($child instanceof DataListRow){
//            $this->rows[] = $child;
//            return $this;
//        }else{
//            // Not possible because of XSD
//            //return parent::addChild($child);
//            throw new \blaze\lang\IllegalArgumentException();
//        }
    }

    public function getRows() {
        return $this->rows;
    }

    public function __construct() {

    }

    public static function create() {
        return new DataList();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'DataListRenderer';
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getVar() {
        return $this->getResolvedExpression($this->var);
    }

    public function setVar($var) {
        $this->var = new \blaze\web\el\Expression($var);
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
