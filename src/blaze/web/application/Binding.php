<?php

namespace blaze\web\application;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\ClassWrapper;

/**
 * Description of Binding
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Binding extends Object {

    private $name;
    private $reference;
    private $default;

    public function __construct($name, $reference, $default = null) {
        $this->name = $name;
        $this->reference = new \blaze\web\el\Expression('{' . $reference . '}');
        $this->default = $default;
    }

    public function getName() {
        return $this->name;
    }

    /**
     *
     * @return \blaze\web\el\Expression
     */
    public function getReference() {
        return $this->reference;
    }

    public function getDefault() {
        return $this->default;
    }

}

?>
