<?php
namespace blaze\persistence\cfg;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Configuration extends Object {

    /**
     * Beschreibung
     */
    public function __construct(){

    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\persistence\SessionFactory Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public function buildSessionFactory(){

     }

     /**
      *
      * @param string $config
      * @return blaze\persistence\cfg\Configuration
      */
     public function configure($config){

         return $this;
     }

     /**
      *
      * @param string $name
      * @param string $value
      * @return blaze\persistence\cfg\Configuration
      */
     public function setProperty($name, $value){

         return $this;
     }
}

?>
