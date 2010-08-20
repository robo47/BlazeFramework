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

     /**
     * - p -> default
     * - b
     * - em
     * - strong
     * - dfn
     * - code
     * - samp
     * - kbd
     * - var
     * - cite
     * - none
     * - h1-h7
     */
    private $type;

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

    public function getType() {
        return $this->getResolvedExpression($this->type);
    }

    public function setType($type) {
        $this->type = new \blaze\web\el\Expression($type);
        return $this;
    }

}

?>
