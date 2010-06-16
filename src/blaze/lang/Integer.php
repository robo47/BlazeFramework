<?php
namespace blaze\lang;

/**
 * Description of Integer
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  RedShadow
 * @todo    Implementing and documenting.
 */
class Integer extends Object implements NativeWrapper {
    private $integer;

    public function __contstruct($integer){
        parent::__construct();
        $this->integer = $integer;
    }

    public function toNative() {
        return $this->integer;
    }

    public static function toHexString($i){
        return self::toUnsignedString($i, 4);
    }

    private static function toUnsignedString($i) {

        return dechex($i);
    }
}
?>
