<?php
namespace blaze\util;
use blaze\lang\Object;

/**
 * Description of ArrayList
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ArrayList extends Object implements ListI {

    private $array = array();
    private $count = 0;

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
     public function get($index){
        if($index < 0 || $index > $this->count)
            throw new \blaze\lang\IndexOutOfBoundsException($index);
        return $this->array[$index];
     }

     public function add($element){
        $this->array[] = $element;
        $this->count++;
     }

     public function count(){
        return count($this->array);
     }
}

?>
