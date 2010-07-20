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
class HtmlTag extends AbstractTag{

    private $xmlns;
    
    /**
     * Beschreibung
     */
    public function __construct($xmlns){
        $this->xmlns = $xmlns;
    }

     public function render(){
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="'.$this->xmlns.'">'.
                $this->renderSubElements().
                '</html>';
     }
    public function create() {
        return new self('http://www.w3.org/1999/xhtml');
    }

}

?>
