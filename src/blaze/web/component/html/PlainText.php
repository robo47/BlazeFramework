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
class PlainText extends \blaze\web\component\UIComponentBase{

    private $value;

    public function __construct(){
    }

    public static function create(){
        return new PlainText();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'PlainTextRenderer';
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

}

?>
