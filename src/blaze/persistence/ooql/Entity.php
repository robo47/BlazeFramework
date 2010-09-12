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
class Entity extends Object implements Joinable, Fromable{

    private $entityName;
    private $entityAlias;

    public function __construct($entityName = null, $entityAlias = null) {
        $this->entityName = $entityName;
        $this->entityAlias = $entityAlias;
    }
    public function getEntityName() {
        return $this->entityName;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    public function getEntityAlias() {
        return $this->entityAlias;
    }

    public function setEntityAlias($entityAlias) {
        $this->entityAlias = $entityAlias;
    }


}

?>
