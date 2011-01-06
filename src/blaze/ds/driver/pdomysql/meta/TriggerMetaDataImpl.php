<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\ds\driver\pdobase\meta\AbstractTriggerMetaData;

/**
 * Description of TriggerMetaDataImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class TriggerMetaDataImpl extends AbstractTriggerMetaData{

    public function __construct(\blaze\ds\meta\TableMetaData $table, $triggerTiming, $triggerEvent, $triggerOrder, $triggerName, $triggerDefinition, $triggerOldName, $triggerNewName) {
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
     * @return int
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

    public function drop() {
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->createStatement();
         $stmt->executeQuery('DROP TRIGGER '.$this->triggerName);
    }

    private function recreateTrigger($definition, $name, $event, $timing, $order, $oldName, $newName){
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->createStatement();
         $stmt->addBatch('DROP TRIGGER '.$this->triggerName);
         $timingS = $timing == 1 ? 'BEFORE' : 'AFTER';
         $eventS = $event == 1 ? 'INSERT' :($event == 2 ? 'UPDATE' : 'DELETE');
         $stmt->addBatch('CREATE TRIGGER '.$name.' '.$timingS.' '.$eventS.' ON '.$this->table->getTableName().' FOR EACH ROW '.$definition);
         $stmt->addBatch('UPDATE information_schema.TRIGGERS SET ACTION_REFERENCE_OLD_TABLE = '.$oldName.', ACTION_REFERENCE_NEW_TABLE = '.$newName.', ACTION_ORDER = '.$order.
                         ' WHERE TRIGGER_NAME = '.$name.' AND EVENT_OBJECT_SCHEMA = '.$this->table->getSchema()->getSchemaName().' AND EVENT_OBJECT_TABLE = '.$this->table->getTableName());

         $this->triggerName = $name;
         $this->triggerDefinition = $definition;
         $this->triggerEvent = $event;
         $this->triggerTiming = $timing;
         $this->triggerOrder = $order;
         $this->triggerOldName = $oldName;
         $this->triggerNewName = $newName;
    }

    public function setTriggerDefinition($triggerDefinition) {
        $this->recreateTrigger($triggerDefinition, $this->triggerName, $this->triggerEvent, $this->triggerTiming, $this->triggerOrder, $this->triggerOldName, $this->triggerNewName);
    }

    public function setTriggerEvent($event) {
        $this->recreateTrigger($this->triggerDefinition, $this->triggerName, $event, $this->triggerTiming, $this->triggerOrder, $this->triggerOldName, $this->triggerNewName);
    }

    public function setTriggerName($name) {
        $this->recreateTrigger($this->triggerDefinition, $name, $this->triggerEvent, $this->triggerTiming, $this->triggerOrder, $this->triggerOldName, $this->triggerNewName);
    }

    public function setTriggerNewName($triggerNewName) {
        $this->recreateTrigger($this->triggerDefinition, $this->triggerName, $this->triggerEvent, $this->triggerTiming, $this->triggerOrder, $this->triggerOldName, $triggerNewName);
    }

    public function setTriggerOldName($triggerOldName) {
        $this->recreateTrigger($this->triggerDefinition, $this->triggerName, $this->triggerEvent, $this->triggerTiming, $this->triggerOrder, $triggerOldName, $this->triggerNewName);
    }

    public function setTriggerOrder($order) {
        $this->recreateTrigger($this->triggerDefinition, $this->triggerName, $this->triggerEvent, $this->triggerTiming, $order, $this->triggerOldName, $this->triggerNewName);
    }

    public function setTriggerTiming($timing) {
        $this->recreateTrigger($this->triggerDefinition, $this->triggerName, $this->triggerEvent, $timing, $this->triggerOrder, $this->triggerOldName, $this->triggerNewName);
    }

}

?>
