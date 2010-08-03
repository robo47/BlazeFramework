<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of CommandLink
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class CommandLink extends \blaze\web\component\UICommand{

    private $title;
    private $styleClass;
    private $clicked;
    private $value;

    public function __construct(){
    }

    public static function create(){
        return new CommandLink();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'CommandLinkRenderer';
    }

    public function getStyleClass() {
        return $this->getResolvedExpression($this->styleClass);
    }

    public function setStyleClass($styleClass) {
        $this->styleClass = new \blaze\web\el\Expression($styleClass);
        return $this;
    }

    public function getTitle() {
        return $this->getResolvedExpression($this->title);
    }

    public function setTitle($title) {
        $this->title = new \blaze\web\el\Expression($title);
        return $this;
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
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
