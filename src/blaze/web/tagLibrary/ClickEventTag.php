<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of ClickEventTag
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ClickEventTag extends AbstractTag{

    private $value;
    
    /**
     * Beschreibung
     */
    public function __construct(){
    }


     public function render(){
        return '$( .'.$this->getParent()->getId().').bind("click",'.$this->renderSubElements().');';
     }
     public function getValue() {
         return $this->value;
     }

     public function setValue($value) {
         $this->value = $value;
         return $this;
     }

     public function create() {
         return new self();
     }

}

?>
