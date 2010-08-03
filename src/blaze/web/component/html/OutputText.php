<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of UIOutput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class OutputText extends \blaze\web\component\UIOutput{

    private $style;
    private $styleClass;
    private $title;

    public function __construct(){
    }

    public static function create(){
        return new OutputText();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'OutputTextRenderer';
    }

    public function getStyle() {
        return $this->getResolvedExpression($this->style);
    }

    public function setStyle($style) {
        $this->style = new \blaze\web\el\Expression($style);
        return $this;
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


}

?>
