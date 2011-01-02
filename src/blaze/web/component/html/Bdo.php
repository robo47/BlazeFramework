<?php
namespace blaze\web\component\html;
use blaze\lang\Object;

/**
 * Description of Bdo
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Bdo extends \blaze\web\component\UIComponentCore{

    private $dir;

    public function __construct(){
    }

    public static function create(){
        return new Bdo();
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'BdoRenderer';
    }

    public function getDir() {
        return $this->getResolvedExpression($this->dir);
    }

    public function setValue($dir) {
        $this->dir = new \blaze\web\el\Expression($dir);
        return $this;
    }
}

?>
