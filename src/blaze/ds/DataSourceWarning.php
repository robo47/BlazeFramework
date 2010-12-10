<?php
namespace blaze\ds;
use blaze\lang\Exception;

/**
 * Description of DataSourceWarning
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class DataSourceWarning extends DataSourceException {
    /**
     *
     * @var blaze\ds\DataSourceWarning
     */
    private $nextWarning;

    public function __construct($reason = null, $SQLState = null, $vendorCode = null, $cause = null){
        parent::__construct($reason, $code, $cause);
    }

    /**
     *
     * @return blaze\ds\DataSourceWarning
     */
    public function getNextWarning() {
        return $this->nextWarning;
    }

    /**
     *
     * @param blaze\ds\DataSourceWarning $nextWarning
     */
    public function setNextWarning($nextWarning) {
        $this->nextWarning = $nextWarning;
    }


}

?>
