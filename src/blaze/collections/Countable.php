<?php

namespace blaze\collections;

/**
 * This is just to provide a framework specific interface in the case that
 * php will use a different namespace for the SPL stuff in further versions.
 * It also extends the interfaces and adds the isEmpty method which shall be used
 * to reduce duplicate code.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface Countable extends \Countable {

    /**
     * Returns wether the object is empty or not.
     * 
     * @return boolean true if the count is 0, otherwise false
     */
    public function isEmpty();

    /**
     * Alias for count() which is more abstract.
     *
     * @return int The size of the object.
     */
    public function size();
}

?>
