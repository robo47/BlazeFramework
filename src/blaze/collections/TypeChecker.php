<?php

namespace blaze\collections;

use blaze\lang\Object;

/**
 * TypeChecker is an implementation which is used by Typed collections to check
 * wether the type of an object is the one which was specified to the typed collection
 * or not.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @author  Christian Beikov
 */
class TypeChecker extends Object {

    private static $typeCheckers = array();
    private static $basicTypes = array('string', 'array', 'resource',
        'float', 'double', 'real',
        'int', 'integer', 'long',
        'bool', 'boolean');
    private $class = null;
    private $type = null;
    private $typeName = null;

    private function __construct($type, $class, $typeName) {
        $this->type = $type;
        $this->class = $class;
        $this->typeName = $typeName;
    }

    /**
     * Returns an instance of TypeChecker for the specified type.
     *
     * @param string|blaze\lang\String|blaze\lang\ClassWrapper $type
     * @return blaze\collections\TypeChecker
     */
    public static function getInstance($type) {
        if ($type === null)
            throw new blaze\lang\NullPointerException();

        $class = null;
        $type = null;
        $typeName = null;

        if ($type instanceof \blaze\lang\ClassWrapper) {
            $class = $type;
            $typeName = $type->getName();
        } else {
            $type = \blaze\lang\String::asNative($type);

            if (in_array($type, self::$basicTypes)) {
                $type = $type;
                $typeName = new \blaze\lang\String($type);
            } else {
                $class = \blaze\lang\ClassWrapper::forName($type);
                $typeName = $class->getName();
            }
        }

        if (!array_key_exists($typeName, self::$typeCheckers))
            self::$typeCheckers[$typeName] = new TypeChecker($type, $class, $typeName);
        return self::$typeCheckers[$typeName];
    }

    /**
     * The name of the type as string.
     * @return blaze\lang\String
     */
    public function getTypeName() {
        return $this->typeName;
    }

    /**
     * Wether the given type is a native one or not.
     * @return boolean
     */
    public function isNative() {
        return $this->class == null;
    }

    /**
     * Checks wether the given value is of the specified type.
     * @param mixed $value
     * @return boolean
     */
    public function isType($value) {
        if ($this->type != null) {
            switch (strtolower($type)) {
                case 'string':
                    return is_string($value);
                case 'array':
                    return is_array($value);
                case 'resource':
                    return is_resource($value);
                case 'float':
                case 'double':
                case 'real':
                    return is_float($value);
                case 'int':
                case 'int':
                case 'long':
                    return is_int($value);
                case 'bool':
                case 'boolean':
                    return is_bool($value);
            }
        } else {
            return $this->class->isInstance($value);
        }
    }

}

?>