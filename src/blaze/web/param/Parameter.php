<?php
namespace blaze\web\param;
use blaze\lang\Object;

/**
 * Description of Parameter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Parameter extends Object{
    protected $name;
    protected $value;
    protected $expression;
    protected $validator;
    protected $converter;
    protected $required;

    function __construct($name = null, $value = null, $expression = null, $validator = null, $converter = null, $required = null) {
        $this->name = $name;
        $this->value = $value;
        $this->expression = $expression;
        $this->validator = $validator;
        $this->converter = $converter;
        $this->required = $required;
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

    public function getExpression() {
        return $this->expression;
    }

    public function setExpression($expression) {
        $this->expression = $expression;
    }

    public function getValidator() {
        return $this->validator;
    }

    public function setValidator($validator) {
        $this->validator = $validator;
    }

    public function getConverter() {
        return $this->converter;
    }

    public function setConverter($converter) {
        $this->converter = $converter;
    }

    public function getRequired() {
        return $this->required;
    }

    public function setRequired($required) {
        $this->required = $required;
    }



}

?>
