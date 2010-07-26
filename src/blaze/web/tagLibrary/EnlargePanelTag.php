<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of EnlargePanelTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class EnlargePanelTag extends AbstractTag{

    private $forId;
    private $duration;
    private $delay;
    
    /**
     * Beschreibung
     */
    public function __construct(){
    }


     public function render(){
        return '<p>'.$this->value.
                $this->renderSubElements().
                '</p>';
     }

     public function create() {
         return new self();
     }
     public function getForId() {
         return $this->forId;
     }

     public function setForId($forId) {
         $this->forId = $forId;
         return $this;
     }

     public function getDuration() {
         return $this->duration;
     }

     public function setDuration($duration) {
         $this->duration = $duration;
         return $this;
     }

     public function getDelay() {
         return $this->delay;
     }

     public function setDelay($delay) {
         $this->delay = $delay;
         return $this;
     }

     
}

?>
