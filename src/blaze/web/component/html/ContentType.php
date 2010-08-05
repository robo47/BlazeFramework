<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of ContentType
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ContentType extends \blaze\web\component\UIComponentBase{

    private $value;
    private $charset;

    public function __construct(){
    }

    public static function create(){
        return new ContentType();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'MetaRenderer';
    }

    public function getValue() {
        return $this->getResolvedExpression($this->value);
    }

    public function setValue($value) {
        $this->value = new \blaze\web\el\Expression($value);
        return $this;
    }

    public function getCharset() {
        return $this->getResolvedExpression($this->charset);
    }

    public function setCharset($charset) {
        $this->charset = new \blaze\web\el\Expression($charset);
        return $this;
    }

}

?>
