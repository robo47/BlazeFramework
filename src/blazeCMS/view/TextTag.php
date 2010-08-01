<?php
namespace blazeCMS\view;
use blaze\lang\Object;

/**
 * Description of TextTag
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class TextTag extends \blaze\web\tag\AbstractTag {

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
