<?php

namespace blaze\persistence;

/**
 * Description of Criteria
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class QueryBuilder {

    private function __construct() {

    }

    /**
     * @return blaze\persistence\impl\queryBuilder\SelectBuilder
     */
    public static function createSelectBuilder() {
        return new impl\queryBuilder\SelectBuilder();
    }

    /**
     * @return blaze\persistence\impl\queryBuilder\FromBuilder
     */
    public static function createFromBuilder() {
        return new impl\queryBuilder\FromBuilder();
    }

    /**
     * @return blaze\persistence\impl\queryBuilder\InsertBuilder
     */
    public static function createInsertBuilder() {
        return new impl\queryBuilder\InsertBuilder();
    }

    /**
     * @return blaze\persistence\impl\queryBuilder\UpdateBuilder
     */
    public static function createUpdateBuilder() {
        return new impl\queryBuilder\UpdateBuilder();
    }

    /**
     * @return blaze\persistence\impl\queryBuilder\DeleteBuilder
     */
    public static function createDeleteBuilder() {
        return new impl\queryBuilder\DeleteBuilder();
    }

}

?>
