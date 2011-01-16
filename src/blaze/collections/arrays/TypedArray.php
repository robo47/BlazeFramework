<?php

namespace blaze\collections\arrays;

use blaze\lang\Object;

/**
 * Similar to a normal ArrayObject but uses a TypeChecker to ensure the right
 * element type.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @property-read int $length
 * @author  Christian Beikov
 */
final class TypedArray extends AbstractArray implements \blaze\collections\Typed {

    /**
     * The object to check value types.
     * @var \blaze\collections\TypeChecker
     */
    private $typeChecker;

    /**
     * The constructor is similar to the one of ArrayObject(AbstractArray) and
     * expects additionally the type of the elements.
     * @param array|int|blaze\collections\ArrayI $arrayOrSize
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     */
    public function __construct($arrayOrSize, $type) {
        $this->typeChecker = \blaze\collections\TypeChecker::getInstance($type);
        parent::__construct($arrayOrSize);

        foreach ($this->objects as $obj) {
            if (!$this->typeChecker->isType($obj))
                throw new \blaze\lang\IllegalArgumentException('The array may only contain objects of the given type ' . $this->typeChecker->getType());
        }
    }

    /**
     * {@inheritDoc}
     * In addition, the value gets type checked.
     * @throws \blaze\lang\IllegalArgumentException If the offset is not a number.
     * @throws \blaze\lang\IndexOutOfBoundsException If the offset is not within the range of the array.
     * @throws \blaze\lang\ClassCastException When the type of the value does not fit.
     */
    public function offsetSet($offset, $value) {
        if (!\blaze\lang\Integer::isNativeType($offset))
            throw new \blaze\lang\IllegalArgumentException('The index must be a number');
        if ($offset < 0 || $offset > $this->size)
            throw new \blaze\lang\IndexOutOfBoundsException($offset);
        if (!$this->typeChecker->isType($value))
            throw new \blaze\lang\ClassCastException('This array may only contain objects of the given type ' . $this->typeChecker->getType());
        $this->objects[$offset] = $value;
    }

}

?>