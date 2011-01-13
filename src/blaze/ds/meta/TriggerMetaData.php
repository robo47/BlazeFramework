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
    /**
     * Defines that the trigger is executed before an event started
     */
    const TIMING_BEFORE = 1;
    /**
     * Defines that the trigger is executed after an event started
     */
    const TIMING_AFTER = 2;
    /**
     * Defines that the trigger is executed on an insert event
     */
    const EVENT_INSERT = 1;
    /**
     * Defines that the trigger is executed on an update event
     */
    const EVENT_UPDATE = 2;
    /**
     * Defines that the trigger is executed on a delete event
     */
    const EVENT_DELETE = 3;

    /**
     * Drops the trigger.
     *
     * @return boolean Wether the action was successful or not.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function drop();

    /**
     * Returns one of the TIMING_* constants
     *
     * @return int The timing at which the trigger will be executed
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggerTiming();

    /**
     * Sets the timing of the trigger, see the constants TIMING_*.
     *
     * @param int $timing The timing at which the trigger will be executed
     * @return \blaze\ds\meta\TriggerMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTriggerTiming($timing);

    /**
     * Returns one of the EVENT_* constants
     *
     * @return int The event at which the trigger will be executed
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggerEvent();

    /**
     * Sets the event of the trigger, see the constants EVENT_*.
     *
     * @param int $event The event at which the trigger will be executed
     * @return \blaze\ds\meta\TriggerMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTriggerEvent($event);

    /**
     * Returns the order of the trigger.
     *
     * @return int The order of the trigger
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggerOrder();

    /**
     * Returns the name of the trigger.
     *
     * @return blaze\lang\String The name of the trigger
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggerName();

    /**
     * Sets the name of the trigger.
     *
     * @param string|\blaze\lang\String $name The name of the trigger
     * @return \blaze\ds\meta\TriggerMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTriggerName($name);

    /**
     * Returns the definition of the trigger.
     * 
     * @return blaze\lang\String The definition of the trigger
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggerDefinition();

    /**
     * Sets the name of the trigger.
     *
     * @param string|\blaze\lang\String $triggerDefinition The definition of the trigger
     * @return \blaze\ds\meta\TriggerMetaData This object for chaining.
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function setTriggerDefinition($triggerDefinition);

    /**
     * Returns the name of the variable of the old record.
     *
     * @return blaze\lang\String The name of the variable for the old record
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggerOldName();

    /**
     * Returns the name of the variable of the new record.
     *
     * @return blaze\lang\String The name of the variable for the new record
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTriggerNewName();

    /**
     * Returns the parent table object.
     *
     * @return blaze\ds\meta\TableMetaData The parent table meta data
     * @throws \blaze\ds\DataSourceException Is thrown when an error occurs.
     */
    public function getTable();
}

?>
