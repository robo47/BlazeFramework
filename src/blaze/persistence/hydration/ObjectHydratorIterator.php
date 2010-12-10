<?php

namespace blaze\persistence\hydration;

use blaze\lang\Object;

/**
 * Description of ObjectHydratorIterator
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ObjectHydratorIterator extends Object implements \blaze\collections\Iterator {
    private $rs;
    private $rsd;
    private $hasNext;
    private $returnObj;

    public function __construct(\blaze\ds\ResultSet $rs, \blaze\persistence\meta\ResultSetDescriptor $rsd){
        $this->rs = $rs;
        $this->rsd = $rsd;
        $this->hasNext = null;
    }
    
    public function current() {
        return $this->returnObj;
    }

    public function hasNext() {
        if($this->hasNext === null)
                $this->hasNext = $this->rs->next();
        return $this->hasNext;
    }

    public function key() {
        return $this->rs->getRow();
    }

    public function next() {
        if($this->hasNext()){
            $this->returnObj = $this->rsd->getResultClassInstance();

            foreach($this->rsd->getFieldMappings() as $column => $propertyPath){
                $classesPath = $propertyPath->getClassesPath();
                $namesPath = $propertyPath->getNamesPath();

                for($i = 0; $i < count($namesPath); $i++){
                    switch (\blaze\lang\String::asNative($classesPath[$i])){
                        case 'int':
                            $this->setObjectValue($this->returnObj, $namesPath, $this->rs->getInt($column));
                            break;
                        case 'blaze\\lang\\String':
                            $this->setObjectValue($this->returnObj, $namesPath, $this->rs->getString($column));
                            break;
                        case 'blaze\util\Date':
                            $this->setObjectValue($this->returnObj, $namesPath, $this->rs->getDate($column));
                            break;
                        default:
                            $this->setObjectValue($this->returnObj, $namesPath, null);
                            break;
                    }
                }
            }
        }else{
            $this->returnObj = null;
        }

        $this->hasNext = null;
        return $this->returnObj;
    }

    public function remove() {}

    public function rewind() {}

    public function valid() {
        return $this->returnObj !== null;
    }

    private function setObjectValue($obj, $namePath, $value){
        for($i = 0; $i < count($namePath) - 1; $i++)
            $obj = $obj->getClass()->getMethod('get'.$namePath[$i]->toUpperCase(true))->invoke($obj,null);

        $obj->getClass()->getMethod('set'.$namePath[count($namePath) - 1]->toUpperCase(true))->invoke($obj,$value);
    }

}

?>
