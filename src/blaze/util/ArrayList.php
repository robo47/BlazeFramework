<?php
namespace blaze\util;
use blaze\lang\Object;

/**
 * Description of ArrayList
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ArrayList extends Object implements ListI {

    private $array = array();
    private $count = 0;

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
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
