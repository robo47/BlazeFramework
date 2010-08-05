<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of CommandButton
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class CommandButton extends \blaze\web\component\UICommand{

    private $clicked;
    private $value;
    private $disabled;

    public function __construct(){
    }

    public static function create(){
        return new CommandButton();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'CommandButtonRenderer';
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getDisabled() {
        return $this->getResolvedExpression($this->disabled);
    }

    public function setDisabled($disabled) {
        $this->disabled = new \blaze\web\el\Expression($disabled);
        return $this;
    }

    public function getClicked() {
        return $this->clicked;
    }

    public function setClicked($clicked) {
        $this->clicked = $clicked;
        return $this;
    }

    public function processApplication(\blaze\web\application\BlazeContext $context) {
        if(!$this->getClicked()) return;
        parent::processApplication($context);
    }


}

?>
