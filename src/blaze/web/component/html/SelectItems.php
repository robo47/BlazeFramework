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
class SelectItems extends \blaze\web\component\UIComponentBase{

    private $value;
    private $labelField;
    private $disabledField;
    private $idField;

    public function __construct() {

    }

    public static function create() {
        return new SelectItems();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return '';
    }

    public function getIdField() {
        return $this->getResolvedExpression($this->idField);
    }

    public function setIdField($idField) {
        $this->idField = new \blaze\web\el\Expression($idField);
        return $this;
    }

    public function getLabelField() {
        return $this->getResolvedExpression($this->labelField);
    }

    public function setLabelField($labelField) {
        $this->labelField = new \blaze\web\el\Expression($labelField);
        return $this;
    }

    public function getDisabledField() {
        return $this->getResolvedExpression($this->disabledField);
    }

    public function setDisabledField($disabledField) {
        $this->disabledField = new \blaze\web\el\Expression($disabledField);
        return $this;
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

}

?>
