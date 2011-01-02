<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of InputText
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class InputBoolean extends \blaze\web\component\UIInput{

    private $type;
    
    public function __construct(){
    }

    public static function create(){
        return new InputBoolean();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'InputBooleanRenderer';
    }

    public function getType() {
        return $this->getResolvedExpression($this->type);
    }

    public function setType($type) {
        $this->type = new \blaze\web\el\Expression($type);
        return $this;
    }
}

?>
