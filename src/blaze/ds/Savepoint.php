<?php

namespace blaze\ds;

/**
 * This represents a save point within a transactin to which can be rolled back.
 * Savepoint can be named and unnamed, unnamed ones get a generated id.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Savepoint {

    /**
     * Returns the name of this savepoint
     *
     * @return 	blaze\lang\String The name of this savepoint
     */
    public function getSavepointName();

    /**
     * Returns the id of this savepoint
     *
     * @return 	int The id of this savepoint
     */
    public function getSavepointId();

}

?>
