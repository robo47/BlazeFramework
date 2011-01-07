<?php

namespace blaze\ds;

use blaze\lang\Exception;

/**
 * Description of DataSourceException
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class BatchUpdateException extends DataSourceException {

    /**
     * The update counts which were successful before the error occured.
     *
     * @var array[int]
     */
    private $updateCounts;

    /**
     * Creates a new BatchUpdateException with the given parameters.
     *
     * @param string|blaze\lang\String $reason The reason for the exception
     * @param string|blaze\lang\String $state The SQL specific state
     * @param int $vendorCode The vendor specific error code
     * @param blaze\lang\Throwable $cause The cause of this exception
     */
    public function __construct($reason = null, $state = null, $vendorCode = null, $cause = null, $updateCounts = null) {
        parent::__construct($reason, $state, $vendorCode, $cause);
        $this->updateCounts = $updateCounts;
    }


    /**
     * The update counts which were successful before the error occured.
     *
     * @return array[int] The successful update counts.
     */
    public function getUpdateCounts() {
        return $this->updateCounts;
    }


}

?>
