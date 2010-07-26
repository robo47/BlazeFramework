<?php
namespace blaze\lang;
/**
 * Description of Enum
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\Object
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Documentation
 */
abstract class Enum extends Object{

    /**
     * Just return __CLASS__
     *
     * @return string
     */
    public static abstract function getClassName();

    /**
     *
     * @return array
     */
    public static function getNames() {
        return array_keys(ClassWrapper::forName(static::getClassName())->getEnumConstants());
    }

    /**
     *
     * @return array
     */
    public static function getValues() {
        return array_values(ClassWrapper::forName(static::getClassName())->getEnumConstants());
    }

    /**
     *
     * @return array
     */
    public static function getEntries() {
        return ClassWrapper::forName(static::getClassName())->getEnumConstants();
    }
    
    /**
     *
     * @param blaze\lang\String|string $name
     * @return mixed
     */
    public static function valueOf($name) {
        if($name instanceof String)
            $constName = $name->toNative();
        else if(!is_string($name))
            throw new IllegalArgumentException('Name hast to be a blaze\lang\String or string!');
        else
            $constName = $name;

        $entries = self::getEntries();

        if(!array_key_exists($name,$entries))
            throw new IllegalArgumentException('The enum constant ' . $name . ' does not exist!');
        return $entries[$name];
    }

}

?>
