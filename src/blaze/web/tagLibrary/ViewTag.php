<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of ViewTag
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ViewTag extends AbstractTag{
    
    /**
     * Beschreibung
     */
    public function __construct(){
    }


     public function render(){
        return '<body>'.$this->renderSubElements().'</body>';
     }
     /**
      *
      * @return blaze\web\tagLibrary\ViewTag
      */
    public function create() {
        return new self();
    }

}

?>
