<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of InputText
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class InputTextArea extends \blaze\web\component\UIInput{

    private $cols;
    private $rows;

    public function __construct(){
    }

    public static function create(){
        return new InputTextArea();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'InputTextAreaRenderer';
    }

    public function getRows() {
        return $this->getResolvedExpression($this->rows);
    }

    public function setRows($rows) {
        $this->rows = new \blaze\web\el\Expression($rows);
        return $this;
    }

    public function getCols() {
        return $this->getResolvedExpression($this->cols);
    }

    public function setCols($cols) {
        $this->cols = new \blaze\web\el\Expression($cols);
        return $this;
    }


}

?>
