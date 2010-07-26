<?php
namespace blaze\ds\meta;

/**
 * Description of TriggerMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface TriggerMetaData {
    /**
     * @return blaze\ds\meta\TriggerTiming
     */
    public function getTriggerTiming();
    /**
     * @return blaze\ds\meta\TriggerEvent
     */
    public function getTriggerEvent();
    /**
     * @return integer
     */
    public function getTriggerOrder();
    /**
     * @return blaze\lang\String
     */
    public function getTriggerName();
    /**
     * @return blaze\lang\String
     */
    public function getTriggerDefinition();
    /**
     * @return blaze\lang\String
     */
    public function getTriggerOldName();
    /**
     * @return blaze\lang\String
     */
    public function getTriggerNewName();
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();
}

?>
