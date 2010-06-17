<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of Double
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class Double extends Object {

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
     * @param blaze\lang\Double|double $value
     * @return double
     */
    public static function asNative($value){
        if($value instanceof Double)
            return $value->value;
        else if(is_double($value))
            return $value;
        else
            return (double)String::asNative($value);
    }

    /**
     *
     * @param blaze\lang\Double|double $value
     * @return blaze\lang\Double
     */
    public static function asWrapper($value){
        if($value instanceof Double)
            return $value;
        else
            return new self($value);
    }
}

?>
