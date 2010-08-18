<?php
namespace blaze\collections\arrays;
use blaze\lang\Object;

/**
 * Description of Arrays
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @property-read int $length
 * @author  Christian Beikov
 * @todo    Implementing and documenting.
 */
final class TypedArray extends AbstractArray {

    private $typeChecker;
    /**
     *
     * @param array|int|blaze\collections\ArrayI $arrayOrSize
     */
    public function __construct($arrayOrSize, $type){
        $this->typeChecker = \blaze\collections\TypeChecker::getInstance($type);
        parent::__construct($arrayOrSize);

        foreach($this->objects as $obj){
            if(!$this->typeChecker->isType($obj))
                    throw new \blaze\lang\IllegalArgumentException('The array may only contain objects of the given type '.$this->typeChecker->getType());
        }
    }

    /**
     *
     * @access private
     */
    public function offsetSet($offset, $value) {
        if(!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if($offset < 0 || $offset > $this->size)
                throw new \blaze\lang\IndexOutOfBoundsException($offset);
        if(!$this->typeChecker->isType($value))
                    throw new \blaze\lang\IllegalArgumentException('This array may only contain objects of the given type '.$this->typeChecker->getType());
       $this->objects[$offset] = $value;
    }
    
}
?>