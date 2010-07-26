<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object,
    blaze\lang\String;

/**
 * Description of FormTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class FormTag extends AbstractTag{

    private $value;
    private $name;
    private $id;
    
    /**
     * Beschreibung
     */
    public function __construct(){
    }


     public function render(){
        return '<form method="post">'.
                $this->renderSubElements().
                '</form>';
     }
     public function getValue() {
         return $this->value;
     }

     public function setValue($value) {
         $this->value = $value;
         return $this;
     }

     public function getName() {
         return $this->name;
     }

     public function setName($name) {
         $this->name = $name;
         return $this;
     }

     public function getId() {
         return $this->id;
     }

     public function setId($id) {
         $this->id = $id;
         return $this;
     }


     public function create() {
         return new self();
     }

}

?>
