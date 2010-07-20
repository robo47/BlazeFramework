<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Long
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Long extends Object implements NativeWrapper{

    private $value;

    public function __construct($value){
        $this->value = self::asNative($value);
    }

    /**
     *
     * @return double
     */
    public function toNative() {
        return $this->value;
    }

    /**
     *
     * @param blaze\lang\Long|long $value
     * @return long
     */
    public static function asNative($value){
        if($value instanceof Long)
            return $value->value;
        else if(is_long($value))
            return $value;
        else
            return (int)String::asNative($value);
    }

    /**
     *
     * @param blaze\lang\Long|long $value
     * @return blaze\lang\Long
     */
    public static function asWrapper($value){
        if($value instanceof Long)
            return $value;
        else
            return new self($value);
    }
}

?>
