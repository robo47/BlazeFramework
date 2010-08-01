<?php
namespace blaze\persistence\cfg;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Configuration extends Object {

    /**
     * Description
     */
    public function __construct(){

    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\persistence\SessionFactory Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
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
