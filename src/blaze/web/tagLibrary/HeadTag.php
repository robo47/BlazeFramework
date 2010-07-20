<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of HeadTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class HeadTag extends AbstractTag{

    private $title;
    /**
     * Beschreibung
     */
    public function __construct(){
    }

     public function render(){
        return '<head><title>'.$this->title.'</title>'.
                $this->renderSubElements().
                '</head>';
     }
    public function create() {
        return new self();
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }


}

?>
