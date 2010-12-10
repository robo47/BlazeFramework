<?php
namespace blaze\persistence\ooql;
use blaze\lang\Object;

/**
 * Description of Select
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Property extends Object implements Argument, Selectable{

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

    public function getPrefix(){
        return $this->getEntityAlias();
    }
    public function getType(){
        return self::PROPERTY;
    }
    public function getAlias(){
        return $this->getPropertyAlias();
    }

}

?>
