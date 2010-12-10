<?php
namespace blaze\ds\meta;

/**
 * Description of TriggerMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface TriggerMetaData {
    const TIMING_BEFORE = 1,
          TIMING_AFTER = 2;
    const EVENT_INSERT = 1,
          EVENT_UPDATE = 2,
          EVENT_DELETE = 3;
    /**
     * Drops the trigger.
     * @return boolean
     */
    public function drop();
    /**
     * One of the TIMING_* constants
     * @return int
     */
    public function getTriggerTiming();
    public function setTriggerTiming($timing);
    /**
     * One of the EVENT_* constants
     * @return int
     */
    public function getTriggerEvent();
    public function setTriggerEvent($event);
    /**
     * @return int
     */
    public function getTriggerOrder();
    public function setTriggerOrder($order);
    /**
     * @return blaze\lang\String
     */
    public function getTriggerName();
    public function setTriggerName($name);
    /**
     * @return blaze\lang\String
     */
    public function getTriggerDefinition();
    public function setTriggerDefinition($triggerDefinition);
    /**
     * @return blaze\lang\String
     */
    public function getTriggerOldName();
    public function setTriggerOldName($triggerOldName);
    /**
     * @return blaze\lang\String
     */
    public function getTriggerNewName();
    public function setTriggerNewName($triggerNewName);
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();
}

?>
