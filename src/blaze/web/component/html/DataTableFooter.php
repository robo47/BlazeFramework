<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of DataTableFooter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class DataTableFooter extends \blaze\web\component\UIComponentCore{

    private $span;

    public function __construct(){
    }

    public static function create(){
        return new DataTableFooter();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return '';
    }

    public function getSpan() {
        return $this->getResolvedExpression($this->span);
    }

    public function setSpan($span) {
        $this->span = new \blaze\web\el\Expression($span);
        return $this;
    }

    public function processRender(\blaze\web\application\BlazeContext $context) {
        foreach($this->getChildren() as $child){
            $renderer = $child->getRenderer($context);
            $renderer->renderBegin($context, $child);
            $renderer->renderAttributes($context, $child);
            $renderer->renderChildren($context, $child);
            $renderer->renderEnd($context, $child);
        }
    }
}

?>
