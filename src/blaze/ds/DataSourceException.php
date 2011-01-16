<?php

namespace blaze\ds;

use blaze\lang\Exception;

/**
 * This exception can be thrown when an error occurs with a datasource end.
 * It provides information about:
 * <ul>
 *  <li>What happened in a summary.</li>
 *  <li>The state code for SQL specific errors.</li>
 *  <li>The vendor specific error code.</li>
 *  <li>The next exception.</li>
 * </ul>
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class DataSourceException extends Exception {

    /**
     * The next exception.
     * @var blaze\ds\DataSourceException
     */
    private $nextException;
    /**
     * The state for SQL specific errors
     * @var \blaze\lang\String
     */
    private $state;

    /**
     * Creates a new DataSourceException with the given parameters.
     *
     * @param string|blaze\lang\String $reason The reason for the exception
     * @param string|blaze\lang\String $state The SQL specific state
     * @param int $vendorCode The vendor specific error code
     * @param blaze\lang\Throwable $cause The cause of this exception
     */
    public function __construct($reason = null, $state = null, $vendorCode = null, $cause = null) {
        parent::__construct($reason, $vendorCode, $cause);
        $this->state = $state;
    }

    /**
     * Returns the state for SQL specific errors
     *
     * @return \blaze\lang\String The state
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Returns the next chained exception.
     *
     * @return blaze\ds\DataSourceException
     */
    public function getNextException() {
        return $this->nextException;
    }

    /**
     * Adds an exception to the end of the chain.
     * @param blaze\ds\DataSourceException $nextException
     */
    public function setNextException(\blaze\ds\DataSourceException $nextException) {
        if($this->nextException === null)
            $this->nextException = $nextException;
        else
            $this->nextException->setNextException($nextException);
    }
}

?>
