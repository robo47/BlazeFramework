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
class Entity extends Object implements Joinable, Fromable {

    private $entityName;
    private $entityAlias;

    public function __construct($entityName = null, $entityAlias = null) {
        $this->entityName = $entityName;
        $this->entityAlias = $entityAlias;
    }

    public function getName() {
        return $this->entityName;
    }

    public function setName($entityName) {
        $this->entityName = $entityName;
    }

    public function getAlias() {
        return $this->entityAlias;
    }

    public function setAlias($entityAlias) {
        $this->entityAlias = $entityAlias;
    }

}

?>
