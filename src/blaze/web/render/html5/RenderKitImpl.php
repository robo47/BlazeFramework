<?php
namespace blaze\web\render\html5;

/**
 * Description of RenderKit
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class RenderKitImpl extends \blaze\lang\Object implements \blaze\web\render\RenderKit{

    private $renderer = array();

    public function __construct(){

    }
    
    public function getRenderer($rendererId){
         if(!array_key_exists($rendererId, $this->renderer))
                 $this->renderer[$rendererId] = \blaze\lang\ClassWrapper::forName('blaze\\web\\render\\html4\\'.$rendererId)->newInstance();
         return $this->renderer[$rendererId];
     }

}

?>
