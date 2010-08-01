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
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
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
