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
class Form extends \blaze\web\component\UIForm{

    private $destination;

    public function __construct(){
    }

    public static function create(){
        return new Form();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'FormRenderer';
    }

    public function getDestination() {
        return $this->getResolvedExpression($this->destination);
    }

    public function setdestination($destination) {
        $this->destination = new \blaze\web\el\Expression($destination);
        return $this;
    }

}

?>
