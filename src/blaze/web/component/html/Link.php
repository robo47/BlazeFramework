<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of Link
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Link extends \blaze\web\component\UIComponentCore{

    private $value;
    private $href;

    public function __construct(){
    }

    public static function create(){
        return new Link();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'LinkRenderer';
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getHref() {
        return $this->getResolvedExpression($this->href);
    }

    public function setHref($href) {
        $this->href = new \blaze\web\el\Expression($href);
        return $this;
    }


}

?>
