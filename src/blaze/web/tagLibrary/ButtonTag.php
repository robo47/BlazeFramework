<?php
namespace blaze\web\tagLibrary;
use blaze\lang\Object,
    blaze\web\JSContainer;

/**
 * Description of ButtonTag
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ButtonTag extends AbstractTag {

    private $value;
    private $id;
    private static $count = 0;

    /**
     * Beschreibung
     */
    public function __construct() {
        $this->id = 'bid-button-'.self::$count++;
    }


    public function render() {
        JSContainer::getInstance()->addCode($this->renderSubElements());
        return '<div><input type="button" id="'.$this->id.'" value="'.$this->value.'"/></div>';
    }
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }


    public function create() {
        return new self();
    }

}

?>
