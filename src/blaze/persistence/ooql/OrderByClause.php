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
class OrderByClause extends Object {
    const ORD_ASC = 'ASC';
    const ORD_DESC = 'DESC';

    private $orderBys = array();

    public function __construct() {

    }

    public function getOrderBys() {
        return $this->orderBys;
    }

    public function addOrderBy(Property $property, $order = OrderByClause::ORD_ASC) {
        $this->gorderBys[] = array($property, $order);
    }

}

?>
