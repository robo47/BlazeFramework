<?php
namespace blaze\util;
use blaze\lang\Object;
/**
 * Description of PhaseEvent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class EventObject extends Object{

    protected $source;

    public function __construct(Object $source){
        $this->source = $source;
    }

     public function getSource(){
        return $this->source;
     }

}

?>
