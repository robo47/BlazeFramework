<?php
namespace blaze\ds\driver\pdobase\meta;
use blaze\lang\Object,
    blaze\ds\meta\TriggerMetaData;

/**
 * Description of AbstractTriggerMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractTriggerMetaData extends Object implements TriggerMetaData{
    /**
     * @return blaze\ds\meta\TriggerTiming
     */
    protected $triggerTiming;
    /**
     * @return blaze\ds\meta\TriggerEvent
     */
    protected $triggerEvent;
    /**
     * @return integer
     */
    protected $triggerOrder;
    /**
     * @return blaze\lang\String
     */
    protected $triggerName;
    /**
     * @return blaze\lang\String
     */
    protected $triggerDefinition;
    /**
     * @return blaze\lang\String
     */
    protected $triggerOldName;
    /**
     * @return blaze\lang\String
     */
    protected $triggerNewName;
    /**
     * @return blaze\ds\meta\TableMetaData
     */
    protected $table;
}

?>
