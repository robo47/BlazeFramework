<?php
namespace blazeServer;
use blaze\lang\Object,
    blaze\lang\Singleton;

/**
 * Description of TestSession
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class TestSession extends Object{
    private $name;
    private $value;
    private $label;

    /**
     * Description
     */
    public function __construct(){
        
    }

    public static function create(){
        return new Test();
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    public function doSomething(){
        var_dump('ActionListener works!');
    }

    public function navigateSomewhere(){
        var_dump('Action works!');
    }


}

?>
