<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractTriggerMetaData;

/**
 * Description of TriggerMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class TriggerMetaDataImpl extends AbstractTriggerMetaData{

    function __construct(\blaze\ds\meta\TableMetaData $table, $triggerTiming, $triggerEvent, $triggerOrder, $triggerName, $triggerDefinition, $triggerOldName, $triggerNewName) {
        $this->table = $table;
        $this->triggerTiming = $triggerTiming;
        $this->triggerEvent = $triggerEvent;
        $this->triggerOrder = $triggerOrder;
        $this->triggerName = $triggerName;
        $this->triggerDefinition = $triggerDefinition;
        $this->triggerOldName = $triggerOldName;
        $this->triggerNewName = $triggerNewName;
    }

    /**
     * @return blaze\ds\meta\TriggerTiming
     */
    public function getTriggerTiming(){
        return $this->triggerTiming;
    }
    /**
     * @return blaze\ds\meta\TriggerEvent
     */
    public function getTriggerEvent(){
        return $this->triggerEvent;
    }
    /**
     * @return integer
     */
    public function getTriggerOrder(){
        return $this->triggerOrder;
    }
    /**
     * @return blaze\lang\String
     */
    public function getTriggerName(){
        return $this->triggerName;
    }
    /**
     * @return blaze\lang\String
     */
    public function getTriggerDefinition(){
        return $this->triggerDefinition;
    }
    /**
     * @return blaze\lang\String
     */
    public function getTriggerOldName(){
        return $this->triggerOldName;
    }
    /**
     * @return blaze\lang\String
     */
    public function getTriggerNewName(){
        return $this->triggerNewName;
    }
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable(){
        return $this->table;
    }
}

?>
