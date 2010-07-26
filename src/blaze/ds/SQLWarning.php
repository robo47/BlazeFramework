<?php
namespace blaze\ds;
use blaze\lang\Exception;

/**
 * Description of SQLWarning
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class SQLWarning extends SQLException {
    /**
     *
     * @var blaze\ds\SQLWarning
     */
    private $nextWarning;

    public function __construct($reason = null, $SQLState = null, $vendorCode = null, $cause = null){
        parent::__construct($reason, $code, $cause);
    }

    /**
     *
     * @return blaze\ds\SQLWarning
     */
    public function getNextWarning() {
        return $this->nextWarning;
    }

    /**
     *
     * @param blaze\ds\SQLWarning $nextWarning
     */
    public function setNextWarning($nextWarning) {
        $this->nextWarning = $nextWarning;
    }


}

?>
