<?php
namespace blaze\web\component;
use blaze\lang\Object;

/**
 * Description of UIViewRoot
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class UIViewRoot extends \blaze\web\component\UIComponentBase{

    private $viewId;
    
    
    public function __construct(){
    }

    public static function create(){
        return new UIViewRoot();
    }

    public function getViewId() {
        return $this->viewId;
    }

    /**
     *
     * @param string|blaze\lang\String $viewId
     * @return blaze\web\component\UIViewRoot 
     */
    public function setViewId($viewId) {
        $this->viewId = $viewId;
         return $this;
    }

    public function getComponentFamily() {
        return 'blaze.web';
    }

    public function getRendererId() {
        return 'ViewRootRenderer';
    }


}

?>
