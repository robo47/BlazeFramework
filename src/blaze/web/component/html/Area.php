<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of Area
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Area extends \blaze\web\component\UIComponentCore{

    private $alt;
    private $coords;
    private $href;
    private $shape;

    public function __construct(){
    }

    public static function create(){
        return new Area();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'AreaRenderer';
    }

    public function getAlt() {
        return $this->getResolvedExpression($this->alt);
    }

    public function setAlt($alt) {
        $this->alt = new \blaze\web\el\Expression($alt);
        return $this;
    }

    public function getCoords() {
        return $this->getResolvedExpression($this->coords);
    }

    public function setCoords($coords) {
        $this->coords = new \blaze\web\el\Expression($coords);
        return $this;
    }

    public function getHref() {
        return $this->getResolvedExpression($this->href);
    }

    public function setHref($href) {
        $this->href = new \blaze\web\el\Expression($href);
        return $this;
    }

    public function getShape() {
        return $this->getResolvedExpression($this->shape);
    }

    public function setShape($shape) {
        $this->shape = new \blaze\web\el\Expression($shape);
        return $this;
    }


}

?>
