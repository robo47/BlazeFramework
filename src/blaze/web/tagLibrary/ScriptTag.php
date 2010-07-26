<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object;

/**
 * Description of ScriptTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ScriptTag extends AbstractTag {

    private $content;
    private $src;

    public function render() {
        if($this->src == null)
            return '<script type="text/javascript">'.
                    $this->content.
                    '</script>';
        else
            return '<script src="'.$this->src.'" type="text/javascript"></script>';
    }
    public function create() {
        return new self();
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getSrc() {
        return $this->src;
    }

    public function setSrc($src) {
        $this->src = $src;
        return $this;
    }


}

?>
