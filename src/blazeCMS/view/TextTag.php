<?php
namespace blazeCMS\view;
use blaze\lang\Object;

/**
 * Description of TextTag
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class TextTag extends \blaze\web\tagLibrary\AbstractTag {

    private $content;

    /**
     *
     * @param string $content
     * @return blazeCMS\view\TextTag
     */
    public function append($content){
        $this->content .= $content;
        return $this;
    }
    /**
     * @return blazeCMS\view\TextTag
     */
    public function create() {
        return new self();
    }

    public function render() {
        return $this->content;
    }
}

?>
