<?php
namespace blaze\util;
use blaze\lang\Object;

/**
 * Description of TimeZone
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class TimeZone extends Object implements \blaze\lang\StaticInitialization{

    private $gmtDifference;
    private static $timeZones = array();
    private static $defaultTimeZone;

    public static function staticInit() {
        self::$timeZones['GMT'] = new self('GMT','GMT',0);
    }

    private function __construct($id, $name, $gmtDiff){
        $this->gmtDifference = $gmtDiff;
    }

    public static function getDefault(){
        //var_dump(date_default_timezone_get());
        return self::$defaultTimeZone;
    }

    public static function setDefault(TimeZone $timeZone){
        self::$defaultTimeZone = $timeZone;
    }

    public static function getTimeZone($identifier){
        if(array_key_exists($identifier, self::$timeZones))
                return self::$timeZones[$identifier];
        return null;
    }
}

?>
