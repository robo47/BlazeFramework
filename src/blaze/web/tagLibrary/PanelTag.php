<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of PanelTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class PanelTag extends AbstractTag{

    private $id;
    
    /**
     * Beschreibung
     */
    public function __construct(){
    }

    /**
     *
     * @return blaze\web\tagLibrary\PanelTag
     */
     public function create() {
         return new self();
     }

     public function render(){
        return '<div id="'.$this->id.'">'.
                $this->renderSubElements().
                '</div>';
     }

     public function getId() {
         return $this->id;
     }

     public function setId($id) {
         $this->id = $id;
         return $this;
     }



}

?>
