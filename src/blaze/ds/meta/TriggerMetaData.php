<?php
namespace blaze\ds\meta;

/**
 * This class represents a trigger of a table object with which all information
 * of the trigger can be get and also changed.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
interface TriggerMetaData {
    const TIMING_BEFORE = 1,
          TIMING_AFTER = 2;
    const EVENT_INSERT = 1,
          EVENT_UPDATE = 2,
          EVENT_DELETE = 3;
    /**
     * Drops the trigger.
     *
     * @return boolean
     */
    public function drop();
    /**
     * Returns one of the TIMING_* constants
     *
     * @return int
     */
    public function getTriggerTiming();
    /**
     * Sets the timing of the trigger, see the constants TIMING_*.
     *
     * @param int $timing
     */
    public function setTriggerTiming($timing);
    /**
     * Returns one of the EVENT_* constants
     *
     * @return int
     */
    public function getTriggerEvent();
    /**
     * Sets the event of the trigger, see the constants EVENT_*.
     *
     * @param int $event
     */
    public function setTriggerEvent($event);
    /**
     * Returns the order of the trigger.
     *
     * @return int
     */
    public function getTriggerOrder();
    /**
     * Sets the order of the trigger.
     *
     * @param int $order
     */
    public function setTriggerOrder($order);
    /**
     * Returns the name of the trigger.
     *
     * @return blaze\lang\String
     */
    public function getTriggerName();
    /**
     * Sets the name of the trigger.
     *
     * @param string|\blaze\lang\String $name
     */
    public function setTriggerName($name);
    /**
     * Returns the definition of the trigger.
     * 
     * @return blaze\lang\String
     */
    public function getTriggerDefinition();
    /**
     * Sets the name of the trigger.
     *
     * @param string|\blaze\lang\String $name
     */
    public function setTriggerDefinition($triggerDefinition);
    /**
     * Returns the name of the variable of the old record.
     *
     * @return blaze\lang\String
     */
    public function getTriggerOldName();
    /**
     * Sets the name of the variable within the trigger, which represents the old record.
     *
     * @param string|\blaze\lang\String $name
     */
    public function setTriggerOldName($triggerOldName);
    /**
     * Returns the name of the variable of the new record.
     *
     * @return blaze\lang\String
     */
    public function getTriggerNewName();
    /**
     * Sets the name of the variable within the trigger, which represents the new record.
     *
     * @param string|\blaze\lang\String $name
     */
    public function setTriggerNewName($triggerNewName);
    /**
     * Returns the parent table object.
     *
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable();
}

?>
