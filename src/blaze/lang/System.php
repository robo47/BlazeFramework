<?php
namespace blaze\lang;

/**
 * Description of System
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
final class System extends Object implements StaticInitialization {

    public static $err;
    public static $in;
    public static $out;
    /**
     *
     * @var blaze\collection\Property
     */
    private static $props;
    /**
     *
     * @var blaze\lang\SecurityManager
     */
    private static $sm;

    private function __construct() {

    }

    public static function staticInit() {
        self::$in = new \blaze\io\NativeInputStream('php://stdin');
        self::$out = new \blaze\io\NativeOutputStream('php://stdout');
        self::$err = new \blaze\io\NativeOutputStream('php://stderr');
    }

        /**
     *
     * @return long
     */
    public static function currentTimeMillis() {
        list($useg, $seg) = explode(' ', microtime());
        return ((float) $useg + (float) $seg);
    }

    public static function gc() {
        gc_collect_cycles();
    }

    public static function getProperties() {
        if (self::$props == null)
            self::initProperties();
        return self::$props;
    }

    public static function getProperty($key, $default = null) {
        switch (String::asNative($key)) {
            case 'user.dir':
                return new String(getcwd());
            default:
                return self::getProperties()->getProperty($key, $default);
        }
    }

    public static function setProperties(\blaze\collection\Properties $props) {
        self::$props = $props;
    }

    public static function setProperty($key, $value) {
        $key = String::asNative($key);
        $oldValue = self::getProperty($key);
        self::$props->setProperty($key, $value);
        return $oldValue;
    }

    public static function getSecurityManager() {
        return $sm;
    }

    public static function setSecurityManager(SecurityManager $sm) {
        $this->sm = $sm;
    }

    public static function identityHashCode(Object $o) {
        return spl_object_hash($o);
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     * @todo	Something which has to be done, implementation or so
     */
    public static function exitApp($code = 0) {
        exit($code);
    }

    private static function initProperties() {
        self::$props = new \blaze\collection\map\Properties();
        /*
         * PHP_OS returns on
         *   WindowsNT4.0sp6  => WINNT
         *   Windows2000      => WINNT
         *   Windows ME       => WIN32
         *   Windows 98SE     => WIN32
         *   FreeBSD 4.5p7    => FreeBSD
         *   Redhat Linux     => Linux
         *   Mac OS X         => Darwin
         */
        self::setProperty('host.os', PHP_OS);
        //self::setProperty('php.classpath', PHP_CLASSPATH);
        // try to determine the host filesystem and set system property
        // used by Fileself::getFileSystem to instantiate the correct
        // abstraction layer

        switch (strtoupper(PHP_OS)) {
            case 'WINNT':
                self::setProperty('host.fs', 'WINNT');
                //self::setProperty('php.interpreter', getenv('PHP_COMMAND'));
                break;
            case 'WIN32':
                self::setProperty('host.fs', 'WIN32');
                break;
            default:
                self::setProperty('host.fs', 'UNIX');
                break;
        }

        self::setProperty('line.separator', PHP_EOL);
        self::setProperty('php.version', PHP_VERSION);
        self::setProperty('user.home', getenv('HOME'));
        self::setProperty('application.startdir', getcwd());
        self::setProperty('blaze.startTime', gmdate('D, d M Y H:i:s', time()) . ' GMT');

        // try to detect machine dependent information
        $sysInfo = array();
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' && function_exists("posix_uname")) {
            $sysInfo = posix_uname();
        } else {
            $sysInfo['nodename'] = php_uname('n');
            $sysInfo['machine'] = php_uname('m');
            //this is a not so ideal substition, but maybe better than nothing
            $sysInfo['domain'] = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "unknown";
            $sysInfo['release'] = php_uname('r');
            $sysInfo['version'] = php_uname('v');
        }


        self::setProperty("host.name", isset($sysInfo['nodename']) ? $sysInfo['nodename'] : "unknown");
        self::setProperty("host.arch", isset($sysInfo['machine']) ? $sysInfo['machine'] : "unknown");
        self::setProperty("host.domain", isset($sysInfo['domain']) ? $sysInfo['domain'] : "unknown");
        self::setProperty("host.os.release", isset($sysInfo['release']) ? $sysInfo['release'] : "unknown");
        self::setProperty("host.os.version", isset($sysInfo['version']) ? $sysInfo['version'] : "unknown");
        unset($sysInfo);
    }

}
?>
