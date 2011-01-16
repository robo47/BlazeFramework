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
class TriggerMetaDataImpl extends AbstractTriggerMetaData {

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

    public function getTriggerTiming() {
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ? AND TRIGGER_NAME = ?');
        $stmt->setString(0, $this->table->getSchema()->getSchemaName());
        $stmt->setString(1, $this->table->getTableName());
        $stmt->setString(2, $this->triggerName);
        $rs = $stmt->executeQuery();

        if ($rs->next()){
            switch($rs->getString('ACTION_TIMING')->toUpperCase()->toNative()){
                case 'BEFORE':
                    return \blaze\ds\meta\TriggerMetaData::TIMING_BEFORE;
                case 'AFTER':
                    return \blaze\ds\meta\TriggerMetaData::TIMING_AFTER;
            }
        }
        return -1;
    }

    public function getTriggerEvent() {
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ? AND TRIGGER_NAME = ?');
        $stmt->setString(0, $this->table->getSchema()->getSchemaName());
        $stmt->setString(1, $this->table->getTableName());
        $stmt->setString(2, $this->triggerName);
        $rs = $stmt->executeQuery();

        if ($rs->next()){
            switch($rs->getString('ACTION_EVENT')->toUpperCase()->toNative()){
                case 'INSERT':
                    return \blaze\ds\meta\TriggerMetaData::EVENT_INSERT;
                case 'UPDATE':
                    return \blaze\ds\meta\TriggerMetaData::EVENT_UPDATE;
                case 'DELETE':
                    return \blaze\ds\meta\TriggerMetaData::EVENT_DELETE;
            }
        }
        return -1;
    }

    public function getTriggerOrder() {
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ? AND TRIGGER_NAME = ?');
        $stmt->setString(0, $this->table->getSchema()->getSchemaName());
        $stmt->setString(1, $this->table->getTableName());
        $stmt->setString(2, $this->triggerName);
        $rs = $stmt->executeQuery();

        if ($rs->next())
            return $rs->getInt('ACTION_ORDER');

        return -1;
    }

    public function getTriggerName() {
        return $this->triggerName;
    }

    public function getTriggerDefinition() {
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.TRIGGERS WHERE EVENT_OBJECT_SCHEMA = ? AND EVENT_OBJECT_TABLE = ? AND TRIGGER_NAME = ?');
        $stmt->setString(0, $this->table->getSchema()->getSchemaName());
        $stmt->setString(1, $this->table->getTableName());
        $stmt->setString(2, $this->triggerName);
        $rs = $stmt->executeQuery();

        if ($rs->next())
            return $rs->getString('ACTION_STATEMENT');

        return -1;
    }

    /**
     * @return blaze\lang\String
     */
    public function getTriggerOldName() {
        return new \blaze\lang\String('OLD');
    }

    /**
     * @return blaze\lang\String
     */
    public function getTriggerNewName() {
        return new \blaze\lang\String('NEW');
    }

    /**
     * @return blaze\ds\meta\TableMetaData
     */
    public function getTable() {
        return $this->table;
    }

    public function drop() {
        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->createStatement();
        $stmt->executeUpdate('DROP TRIGGER ' . $this->triggerName);
    }

    private function recreateTrigger($definition, $name, $event, $timing) {
        $timingS = $timing == 1 ? 'BEFORE' : 'AFTER';
        $eventS = $event == 1 ? 'INSERT' : ($event == 2 ? 'UPDATE' : 'DELETE');

        $stmt = $this->schema->getDatabaseMetaData()->getConnection()->createStatement();
        $stmt->addBatch('DROP TRIGGER ' . $this->table->getSchema()->getSchemaName() . '.' . $this->table->getTableName() . '.' . $this->triggerName);
        $stmt->addBatch('CREATE TRIGGER ' . $name . ' ' . $timingS . ' ' . $eventS . ' ON ' . $this->table->getSchema()->getSchemaName() . '.' . $this->table->getTableName() . ' FOR EACH ROW ' . $definition);
        $stmt->executeBatch();

        $this->triggerName = $name;
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

    public function setTriggerTiming($timing) {
        $this->recreateTrigger($this->triggerDefinition, $this->triggerName, $this->triggerEvent, $timing, $this->triggerOrder, $this->triggerOldName, $this->triggerNewName);
    }

}

?>
