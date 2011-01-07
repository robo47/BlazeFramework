<?php

namespace blaze\persistence\ooql;

use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class Property extends Object implements Argument, Selectable {

    private $entityAlias;
    private $propertyName;
    private $propertyAlias;

    public function __construct($entityAlias = null, $propertyName = null, $propertyAlias = null) {
        $this->entityAlias = $entityAlias;
        $this->propertyName = $propertyName;
        $this->propertyAlias = $propertyAlias;
    }

    public function getEntityAlias() {
        return $this->entityAlias;
    }

    public function setEntityAlias($entityAlias) {
        $this->entityAlias = $entityAlias;
    }

    public function getPropertyName() {
        return $this->propertyName;
    }

    public function setPropertyName($propertyName) {
        $this->propertyName = $propertyName;
    }

    public function getPropertyAlias() {
        return $this->propertyAlias;
    }

    public function setPropertyAlias($propertyAlias) {
        $this->propertyAlias = $propertyAlias;
    }

    public function getPrefix() {
        return $this->getEntityAlias();
    }

    public function getType() {
        return self::PROPERTY;
    }

    public function getAlias() {
        return $this->getPropertyAlias();
    }

}

?>
