<?php
namespace blazeServer;
use blaze\lang\Object,
    blaze\web\WebConfig,
    blaze\lang\Singleton;

/**
 * Description of Test
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Test extends Object{
    private $name;
    private $value;
    private $label;

    /**
     * Beschreibung
     */
    public function __construct(){
        
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function doSomething(){
        var_dump('ActionListener works!');
    }

    public function navigateSomewhere(){
        var_dump('Action works!');
    }


}

?>
