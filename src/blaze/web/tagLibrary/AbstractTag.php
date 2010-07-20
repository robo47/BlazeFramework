<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of HtmlTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractTag extends Object implements Tag {

    private $elements = array();
    private $parent;


     public function renderSubElements(){
         $output = '';
        foreach($this->elements as $element)
                $output .= $element->render();
        return $output;
     }

     public function add(Tag $elem){
        $this->elements[] = $elem;
        $elem->setParent($this);
        return $this;
     }

    public function setParent($parent){
        $this->parent = $parent;
        return $this;
    }

    public function getParent(){
        return $this->parent;
    }

    public function getChildren(){
        return $this->elements;
    }
}

?>
