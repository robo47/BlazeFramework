<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of CustomHandlerTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class CustomHandlerTag extends AbstractTag{

    private $name;
    private $content;
    
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
     public function getName() {
         return $this->name;
     }

     public function setName($name) {
         $this->name = $name;
         return $this;
     }
     public function getContent() {
         return $this->content;
     }

     public function setContent($content) {
         $this->content = $content;
         return $this;
     }

     
     
}

?>
