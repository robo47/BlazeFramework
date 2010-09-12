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
class UpdateStatement extends Object implements Statement{

    private $entity;
    private $properties = array();
    private $values = array();
    private $whereClause;

    public function __construct(Entity $entity, WhereClause $whereClause = null) {
        $this->entity = $entity;
        $this->whereClause = $whereClause;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function getValues() {
        return $this->values;
    }

    public function add(Property $property, Argument $val) {
        $this->properties[] = $property;
        $this->values[] = $val;
    }

    public function getWhereClause() {
        return $this->whereClause;
    }

    public function setWhereClause(WhereClause $whereClause) {
        $this->whereClause = $whereClause;
    }

}

?>
