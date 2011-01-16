<?php

namespace blaze\lang;

/**
 * Description of System
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
final class System extends Object implements StaticInitialization {

    public static $err;
    public static $in;
    public static $out;
    /**
     *
     * @var blaze\collections\Property
     */
    private static $props;
    /**
     *
     * @var blaze\lang\SecurityManager
     */
    private static $sm;
    private static $cachedHints = array();
    /**
     *
     * @var mixed
     */
    private static $oldErrorHandler;
    /**
     *
     * @var mixed
     */
    private static $oldExceptionHandler;

    private function __construct() {

    }

    /**
     * This method handles every error from PHP and decides
     * wether this is a real error or not. The type hinting of
     * native types, widening and auto boxing is supported through this method.
     *
     * @access private
     * @param int $errorLevel
     * @param string $errorMessage
     * @return boolean False if an error occured, otherwise true
     */
    public static function systemErrorHandler($errorLevel, $errorMessage, $errorFile, $errorLine, &$errorContext) {
        switch ($errorLevel) {
            case E_USER_ERROR:
            // User error

            case E_WARNING:
            // Runtime warnings
            case E_USER_WARNING:
            // User warning

            case E_NOTICE:
                // This could be used for operator overloading but the errorContext does not provide references to the objects
//                var_dump($errorContext);
//                $keys = array_keys($errorContext);
//                $errorContext[$keys[count($keys) - 1]] = $errorContext[$keys[count($keys) - 1]]->toNative();
//                var_dump($errorContext);
//                return true;
            // Runtime notices
            case E_USER_NOTICE:
            // User notice

            case E_DEPRECATED:
            case E_USER_DEPRECATED:

            case E_STRICT:
                break;
//                return false;

            case E_RECOVERABLE_ERROR:
                $ok = false;
                $matches = null;

                if (array_key_exists($errorMessage, self::$cachedHints))
                    $matches = self::$cachedHints[$errorMessage];
                else
                    preg_match('/^Argument (?<argNumber>\d+) passed to (?<namespace>(([a-zA-Z_]{1}[a-zA-Z0-9_]+)\\\)+)?[:a-zA-Z0-9_]+\(\) must (be an instance of|be an|implement interface) (?<hintName>[a-zA-Z0-9_\\\]+), (instance of )?(?<typeName>[a-zA-Z0-9_\\\]+) given/AUD', $errorMessage, $matches);

                if ($matches !== null) {
                    if($matches['typeName'] === 'null')
                        throw new NullPointerException();
                    $argNumber = ((int) $matches['argNumber']) - 1;
                    $args = self::getArgsOfErrorCall();

                    switch ($matches['hintName']) {
                        case 'boolean':
                            if ($matches['typeName'] === 'blaze\\lang\\Boolean') {
                                var_dump('Unboxing does not work yet!');
                                $args[$argNumber] = $args[$argNumber]->toNative();
                                $ok = true;
                            } else {
                                $ok = $matches['typeName'] === 'boolean';
                            }
                            break;
                        case 'blaze\\lang\\Boolean':
                            if ($matches['typeName'] === 'boolean') {
                                $args[$argNumber] = new Boolean($args[$argNumber]);
                                $ok = true;
                            }
                            break;
                        case 'byte':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    $ok = Byte::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = (int) $args[$argNumber];
                            }
                            break;
                        case 'blaze\\lang\\Byte':
                            if ($matches['typeName'] === 'integer' || $matches['typeName'] === 'double') {
                                $ok = Byte::isNativeType($args[$argNumber]);

                                if ($ok)
                                    $args[$argNumber] = new Byte($args[$argNumber]);
                            }
                            break;
                        case 'short':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    $ok = Short::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = (int) $args[$argNumber];
                            }
                            break;
                        case 'blaze\\lang\\Short':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                    $args[$argNumber] = new Short($args[$argNumber]->toNative());
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    $ok = Short::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = new Short($args[$argNumber]);
                            }
                            break;
                        case 'int':
                            switch ($matches['typeName']) {
                                case 'integer':
                                    $ok = true;
                                    break;
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                                case 'double':
                                    $ok = Integer::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = (int) $args[$argNumber];
                            }
                            break;
                        case 'blaze\\lang\\Integer':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                    $args[$argNumber] = new Integer($args[$argNumber]->toNative());
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    $ok = Integer::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = new Integer($args[$argNumber]);
                            }
                            break;
                        case 'long':
                            switch ($matches['typeName']) {
                                case 'integer':
                                    $ok = true;
                                    break;
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                case 'blaze\\lang\\Long':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                                case 'double':
                                    $ok = Long::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = (float) $args[$argNumber];
                            }
                            break;
                        case 'blaze\\lang\\Long':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                    $args[$argNumber] = new Long($args[$argNumber]->toNative());
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    $ok = Long::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = new Long($args[$argNumber]);
                            }
                            break;
                        case 'float':
                            switch ($matches['typeName']) {
                                case 'integer':
                                    $ok = true;
                                    break;
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                case 'blaze\\lang\\Long':
                                case 'blaze\\lang\\Float':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                                case 'double':
                                    $ok = Float::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = (float) $args[$argNumber];
                            }
                            break;
                        case 'blaze\\lang\\Float':

                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                case 'blaze\\lang\\Long':
                                    $args[$argNumber] = new Float($args[$argNumber]->toNative());
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    $ok = Float::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = new Float($args[$argNumber]);
                            }
                            break;
                        case 'double':
                            switch ($matches['typeName']) {
                                case 'integer':
                                    $ok = true;
                                    break;
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                case 'blaze\\lang\\Long':
                                case 'blaze\\lang\\Float':
                                case 'blaze\\lang\\Double':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                                case 'double':
                                    $ok = Double::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = (float) $args[$argNumber];
                            }
                            break;
                        case 'blaze\\lang\\Double':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                case 'blaze\\lang\\Long':
                                case 'blaze\\lang\\Float':
                                    $args[$argNumber] = new Double($args[$argNumber]->toNative());
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    $ok = Double::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = new Double($args[$argNumber]);
                                    break;
                            }
                            break;
                        case 'char':
                            switch ($matches['typeName']) {
                                case 'string':
                                    $ok = Character::isNativeType($args[$argNumber]);
                                    break;
                                case 'blaze\\lang\\Character':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                            }
                            break;
                        case 'blaze\\lang\\Character':
                            if ($matches['typeName'] === 'string') {
                                $ok = Character::isNativeType($args[$argNumber]);

                                if ($ok)
                                    $args[$argNumber] = new Character($args[$argNumber]);
                            }
                            break;
                        case 'string':
                            switch ($matches['typeName']) {
                                case 'integer':
                                case 'double':
                                    $args[$argNumber] = (string) $args[$argNumber];
                                    $ok = true;
                                    break;
                                case 'blaze\\lang\\String':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                            }
                            break;
                        case 'blaze\\lang\\String':
                            if ($matches['typeName'] === 'string') {
                                $args[$argNumber] = new String($args[$argNumber]);
                                $ok = true;
                            }
                            break;
                        case 'array':
                            switch ($matches['typeName']) {
                                case 'object':
                                    if (!$args[$argNumber] instanceof \blaze\collections\ArrayI)
                                        break;
                                case 'blaze\\collections\\arrays\\ArrayObject':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = $args[$argNumber]->toNative();
                                    $ok = true;
                                    break;
                            }
                            break;
                        case 'blaze\\collections\\ArrayI':
                        case 'blaze\\collections\\arrays\\ArrayObject':
                            if ($matches['typeName'] === 'array') {
                                $ok = \blaze\collections\arrays\ArrayObject::isNativeType($args[$argNumber]);

                                if ($ok)
                                    $args[$argNumber] = new \blaze\collections\arrays\ArrayObject($args[$argNumber]);
                            }
                            break;
                        case 'blaze\\math\\BigInteger':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                case 'blaze\\lang\\Long':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = new \blaze\math\BigInteger($args[$argNumber]->toNative());
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                case 'string':
                                    $ok = \blaze\math\BigInteger::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = new \blaze\math\BigInteger($args[$argNumber]);
                            }
                            break;
                        case 'blaze\\math\\BigDecimal':
                            switch ($matches['typeName']) {
                                case 'blaze\\lang\\Byte':
                                case 'blaze\\lang\\Short':
                                case 'blaze\\lang\\Integer':
                                case 'blaze\\lang\\Long':
                                case 'blaze\\lang\\Float':
                                case 'blaze\\lang\\Double':
                                case 'blaze\\math\\BigInteger':
                                    var_dump('Unboxing does not work yet!');
                                    $args[$argNumber] = new \blaze\math\BigDecimal($args[$argNumber]->toNative());
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                case 'string':
                                    $ok = \blaze\math\BigDecimal::isNativeType($args[$argNumber]);

                                    if ($ok)
                                        $args[$argNumber] = new \blaze\math\BigDecimal($args[$argNumber]);
                            }
                            break;
                        case 'blaze\\lang\\Reflectable':
                        case 'blaze\\lang\\Object':
                            switch ($matches['typeName']) {
                                case 'boolean':
                                    $args[$argNumber] = new Boolean($args[$argNumber]);
                                    $ok = true;
                                    break;
                                case 'integer':
                                case 'double':
                                    if (($class = Number::getNumberClass($args[$argNumber])) != null) {
										if(Integer::isNativeType($args[$argNumber]))
											$className = 'blaze\\lang\\Integer';
										else if(Double::isNativeType($args[$argNumber]))
											$className = 'blaze\\lang\\Double';
										else
											$className = $class->getName()->toNative();
                                        $args[$argNumber] = $className::asWrapper($args[$argNumber]);
                                        $ok = true;
                                    }
                                    break;
                                case 'string':
                                    if (\blaze\math\BigInteger::isNativeType($args[$argNumber]))
                                        $args[$argNumber] = new \blaze\math\BigInteger($args[$argNumber]);
                                    else if (\blaze\math\BigDecimal::isNativeType($args[$argNumber]))
                                        $args[$argNumber] = new \blaze\math\BigDecimal($args[$argNumber]);
                                    else
                                        $args[$argNumber] = new String($args[$argNumber]);
                                    $ok = true;
                                    break;
                                case 'array':
                                    $args[$argNumber] = new \blaze\collections\arrays\ArrayObject($args[$argNumber]);
                                    $ok = true;
                                    break;
                            }
                            break;
                        default:
                            $ok = false;
                    }

                    if ($ok) {
                        self::$cachedHints[$errorMessage] = $matches;
                        return true;
                    }
                    return false;
                }
        }

        return false;
    }

    private static function getArgsOfErrorCall() {
        $debug = debug_backtrace();
        return $debug[2]['args'];
    }

    /**
     * This method handles every exception which is thrown but not catched.
     * 
     * @access private
     * @param \Exception $exception
     */
    public static function systemExceptionHandler(\Exception $exception) {
        echo $exception->getTraceAsString();
    }

    public static function staticInit() {
        self::$oldErrorHandler = set_error_handler(array('blaze\lang\System', 'systemErrorHandler'));
//        self::$oldExceptionHandler = set_exception_handler(array('blaze\lang\System', 'systemExcetionHandler'));
        error_reporting(E_ALL | E_STRICT);
        set_time_limit(0);
        self::$in = new \blaze\io\input\NativeInputStream('php://stdin');
        self::$out = new \blaze\io\output\PrintStream(new \blaze\io\output\NativeOutputStream('php://stdout'));
        self::$err = new \blaze\io\output\PrintStream(new \blaze\io\output\NativeOutputStream('php://stderr'));
    }

    /**
     *
     * @return long
     */
    public static function currentTimeMillis() {
        return microtime(true) * 1000;
    }

    /**
     *
     * @return long
     */
    public static function nanoTime() {
        return microtime(true) * 1000000000;
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

    public static function setProperties(\blaze\collections\Properties $props) {
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

    public static function identityHashCode(Reflectable $o) {
        if ($o === null)
            return 0;
        return spl_object_hash($o);
    }

    /**
     * Description
     *
     * @param 	blaze\lang\Object $var Description of the parameter $var
     * @return 	blaze\lang\Object Description of what the method returns
     * @see 	Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
     * @throws	blaze\lang\Exception
     */
    public static function exitApp($code = 0) {
        exit($code);
    }

    private static function initProperties() {
        self::$props = new \blaze\collections\map\Properties();
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
        $home = getenv('HOME');
        self::setProperty('user.home', $home === false ? '' : $home);
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
