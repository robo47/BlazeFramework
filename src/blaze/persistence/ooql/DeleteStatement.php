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
class DeleteStatement extends Object implements Statement{

    private $entity;
    private $whereClause;

    public function __construct(Entity $entity, WhereClause $whereClause = null) {
        $this->entity = $entity;
        $this->whereClause = $whereClause;
    }
    public function getEntity() {
        return $this->entity;
    }

    public function getWhereClause() {
        return $this->whereClause;
    }

    public function setWhereClause(WhereClause $whereClause) {
        $this->whereClause = $whereClause;
    }

}

?>
