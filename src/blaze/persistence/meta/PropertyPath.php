<?php
namespace blaze\persistence\meta;
use blaze\lang\Object;

/**
 * Description of PropertyPath
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class PropertyPath extends Object{
    private $classesPath;
    private $namesPath;

    public function __construct(){
        $this->classesPath = array();
        $this->namesPath = array();
    }

    public function addPathStep($className, $propertyName){
        $this->classesPath[] = $className;
        $this->namesPath[] = $propertyName;
    }

    public function getNamesPath(){
        return $this->namesPath;
    }

    public function getClassesPath(){
        return $this->classesPath;
    }

}

?>
