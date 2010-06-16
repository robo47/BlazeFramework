<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of PlainTag
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class PlainTag extends AbstractTag{

    private $content;
    

     public function render(){
        return $content;
     }
    public function create() {
        return new self();
    }
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }



}

?>
