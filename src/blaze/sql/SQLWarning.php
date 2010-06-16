<?php
namespace blaze\sql;
use blaze\lang\Exception;

/**
 * Description of SQLWarning
 *
 * @author  RedShadow
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
     * @var blaze\sql\SQLWarning
     */
    private $nextWarning;

    public function __construct($reason = null, $SQLState = null, $vendorCode = null, $cause = null){
        parent::__construct($reason, $code, $cause);
    }

    /**
     *
     * @return blaze\sql\SQLWarning
     */
    public function getNextWarning() {
        return $this->nextWarning;
    }

    /**
     *
     * @param blaze\sql\SQLWarning $nextWarning
     */
    public function setNextWarning($nextWarning) {
        $this->nextWarning = $nextWarning;
    }


}

?>
