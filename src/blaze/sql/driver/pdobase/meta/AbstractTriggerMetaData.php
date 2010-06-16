<?php
namespace blaze\sql\driver\pdobase\meta;
use blaze\sql\meta\TriggerMetaData;

/**
 * Description of AbstractTriggerMetaData
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractTriggerMetaData implements TriggerMetaData{
    /**
     * @return blaze\sql\meta\TriggerTiming
     */
    public function getTriggerTiming();
    /**
     * @return blaze\sql\meta\TriggerEvent
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
     * @return blaze\sql\meta\TableMetaData
     */
    public function getTable();
}

?>
