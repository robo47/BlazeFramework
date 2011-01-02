<?php

namespace blazeServer\source\netlet\http;

use blaze\lang\Object,
 blaze\lang\Cloneable,
 blaze\lang\String,
 blaze\lang\IllegalArgumentException;

/**
 * Description of HttpCookieImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0

 */
class HttpUserAgentImpl extends Object implements Cloneable, \blaze\netlet\http\HttpUserAgent {

    private $browser = self::BROWSER_UNKNOWN;
    private $browserMajorVersion = 0;
    private $browserMinorVersion = 0;
    private $browserVersionString = '';
    private $cssVersion = 2;
    private $htmlVersion = 4;
    private $robot = false;
    private $mobile = false;
    private $operatingSystem = self::OS_UNKNOWN;
    private $userAgentString;
    // Only for lazy determination
    private $checkedBrowser = false;
    private $checkedOs = false;

    /**
     *
     * @param blaze\lang\String|string $userAgent The user agent string
     */
    public function __construct($userAgent) {
        $this->userAgentString = String::asWrapper($userAgent);
    }

    public function getBrowser() {
        if (!$this->checkedBrowser)
            $this->determineBrowser();
        return $this->browser;
    }

    public function getBrowserMajorVersion() {
        if (!$this->checkedBrowser)
            $this->determineBrowser();
        return $this->browserMajorVersion;
    }

    public function getBrowserMinorVersion() {
        if (!$this->checkedBrowser)
            $this->determineBrowser();
        return $this->browserMinorVersion;
    }

    public function getBrowserVersionString() {
        if (!$this->checkedBrowser)
            $this->determineBrowser();
        return $this->browserVersionString;
    }

    public function getCssVersion() {
        if (!$this->checkedBrowser)
            $this->determineBrowser();
        return $this->cssVersion;
    }

    public function getHtmlVersion() {
        if (!$this->checkedBrowser)
            $this->determineBrowser();
        return $this->htmlVersion;
    }

    public function getOperatingSystem() {
        if (!$this->checkedOs)
            $this->determineOs();
        return $this->operatingSystem;
    }

    public function isMobile() {
        if (!$this->checked)
            $this->determine();
        return $this->mobile;
    }

    public function isRobot() {
        if (!$this->checked)
            $this->determine();
        return $this->robot;
    }

    public function getUserAgentString() {
        return $this->userAgentString;
    }

    private function setBrowserVersionString($versionString) {
        $this->browserVersionString = $versionString;
        preg_match('/^([0-9])\.([0-9])(.*)/i', $this->browserVersionString, $matches);
        $this->browserMajorVersion = $matches[1];
        $this->browserMinorVersion = $matches[2];
    }

    private function determineBrowser() {
        // well-known, well-used
        // Special Notes:
        // (1) Opera must be checked before FireFox due to the odd
        //     user agents used in some older versions of Opera
        // (2) WebTV is strapped onto Internet Explorer so we must
        //     check for WebTV before IE
        // (3) (deprecated) Galeon is based on Firefox and needs to be
        //     tested before Firefox is tested
        // (4) OmniWeb is based on Safari so OmniWeb check must occur
        //     before Safari
        // (5) Netscape 9+ is based on Firefox so Netscape checks
        //     before FireFox are necessary
        return $this->checkBrowserWebTv() ||
        $this->checkBrowserInternetExplorer() ||
        $this->checkBrowserOpera() ||
        $this->checkBrowserGaleon() ||
        $this->checkBrowserNetscapeNavigator9Plus() ||
        $this->checkBrowserFirefox() ||
        $this->checkBrowserChrome() ||
        $this->checkBrowserOmniWeb() ||
        $this->checkBrowserSafari() ||
        // mobile
        $this->checkBrowserAndroid() ||
        $this->checkBrowseriPad() ||
        $this->checkBrowseriPod() ||
        $this->checkBrowseriPhone() ||
        $this->checkBrowserBlackBerry() ||
        $this->checkBrowserNokia() ||
        // bots
        $this->checkBrowserGoogleBot() ||
        $this->checkBrowserSlurp() ||
        // other
        $this->checkBrowserNetPositive() ||
        $this->checkBrowserFirebird() ||
        $this->checkBrowserKonqueror() ||
        $this->checkBrowserIcab() ||
        $this->checkBrowserPhoenix() ||
        $this->checkBrowserAmaya() ||
        $this->checkBrowserLynx() ||
        $this->checkBrowserShiretoko() ||
        $this->checkBrowserIceCat() ||
        $this->checkBrowserW3CValidator() ||
        $this->checkBrowserAol() ||
        $this->checkBrowserMozilla(); /* Mozilla is such an open standard that you must check it last */
    }

    private function determineOs() {
        if (stripos($this->userAgentString, 'windows') !== false) {
            $this->operatingSystem = self::OS_WINDOWS;
        } else if (stripos($this->userAgentString, 'iPad') !== false) {
            $this->operatingSystem = self::OS_IPAD;
        } else if (stripos($this->userAgentString, 'iPod') !== false) {
            $this->operatingSystem = self::OS_IPOD;
        } else if (stripos($this->userAgentString, 'iPhone') !== false) {
            $this->operatingSystem = self::OS_IPHONE;
        } elseif (stripos($this->userAgentString, 'mac') !== false) {
            $this->operatingSystem = self::OS_APPLE;
        } elseif (stripos($this->userAgentString, 'linux') !== false) {
            $this->operatingSystem = self::OS_LINUX;
        } else if (stripos($this->userAgentString, 'Nokia') !== false) {
            $this->operatingSystem = self::OS_NOKIA;
        } else if (stripos($this->userAgentString, 'BlackBerry') !== false) {
            $this->operatingSystem = self::OS_BLACKBERRY;
        } elseif (stripos($this->userAgentString, 'FreeBSD') !== false) {
            $this->operatingSystem = self::OS_FREEBSD;
        } elseif (stripos($this->userAgentString, 'OpenBSD') !== false) {
            $this->operatingSystem = self::OS_OPENBSD;
        } elseif (stripos($this->userAgentString, 'NetBSD') !== false) {
            $this->operatingSystem = self::OS_NETBSD;
        } elseif (stripos($this->userAgentString, 'OpenSolaris') !== false) {
            $this->operatingSystem = self::OS_OPENSOLARIS;
        } elseif (stripos($this->userAgentString, 'SunOS') !== false) {
            $this->operatingSystem = self::OS_SUNOS;
        } elseif (stripos($this->userAgentString, 'OS\/2') !== false) {
            $this->operatingSystem = self::OS_OS2;
        } elseif (stripos($this->userAgentString, 'BeOS') !== false) {
            $this->operatingSystem = self::OS_BEOS;
        } elseif (stripos($this->userAgentString, 'win') !== false) {
            $this->operatingSystem = self::OS_WINDOWS;
        }
    }

    // ---------------------------------
    // checks for the browsers

    private function checkBrowserBlackBerry() {
        if (stripos($this->userAgentString, 'blackberry') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'BlackBerry'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_BLACKBERRY;
            $this->mobile = true;
            return true;
        }
        return false;
    }

    private function checkBrowserAol() {
        if (stripos($this->userAgentString, 'aol') !== false) {
            $aversion = explode(' ', stristr($this->userAgentString, 'AOL'));
            $this->browser = self::BROWSER_AOL;
            $this->setBrowserVersionString($aversion[1]);
            return true;
        }
        return false;
    }

    private function checkBrowserGoogleBot() {
        if (stripos($this->userAgentString, 'googlebot') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'googlebot'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString(str_replace(';', '', $aversion[0]));
            $this->browser = self::BROWSER_GOOGLEBOT;
            $this->robot = true;
            return true;
        }
        return false;
    }

    private function checkBrowserW3CValidator() {
        if (stripos($this->userAgentString, 'W3C-checklink') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'W3C-checklink'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_W3CVALIDATOR;
            return true;
        } else if (stripos($this->userAgentString, 'W3C_Validator') !== false) {
            // Some of the Validator versions do not delineate w/ a slash - add it back in
            $ua = str_replace('W3C_Validator ', 'W3C_Validator/', $this->userAgentString);
            $aresult = explode('/', stristr($ua, 'W3C_Validator'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_W3CVALIDATOR;
            return true;
        }
        return false;
    }

    private function checkBrowserSlurp() {
        if (stripos($this->userAgentString, 'slurp') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Slurp'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_SLURP;
            $this->robot = true;
            return true;
        }
        return false;
    }

    private function checkBrowserInternetExplorer() {

        // Test for v1 - v1.5 IE
        if (stripos($this->userAgentString, 'microsoft internet explorer') !== false) {
            $this->browser = self::BROWSER_IE;
            $this->setBrowserVersionString('1.0');
            $aresult = stristr($this->userAgentString, '/');
            if (preg_match('/308|425|426|474|0b1/i', $aresult)) {
                $this->setBrowserVersionString('1.5');
            }
            return true;
        }
        // Test for versions > 1.5
        else if (stripos($this->userAgentString, 'msie') !== false && stripos($this->userAgentString, 'opera') === false) {
            $aresult = explode(' ', stristr(str_replace(';', '; ', $this->userAgentString), 'msie'));
            $this->browser = self::BROWSER_IE;
            $this->setBrowserVersionString(str_replace(array('(', ')', ';'), '', $aresult[1]));
            return true;
        }
        // Test for Pocket IE
        else if (stripos($this->userAgentString, 'mspie') !== false || stripos($this->userAgentString, 'pocket') !== false) {
            $aresult = explode(' ', stristr($this->userAgentString, 'mspie'));
            $this->operatingSystem = self::OS_WINDOWS_CE;
            $this->browser = self::BROWSER_POCKET_IE;
            $this->mobile = true;

            if (stripos($this->userAgentString, 'mspie') !== false) {
                $this->setBrowserVersionString($aresult[1]);
            } else {
                $aversion = explode('/', $this->userAgentString);
                $this->setBrowserVersionString($aversion[1]);
            }
            return true;
        }
        return false;
    }

    private function checkBrowserOpera() {
        if (stripos($this->userAgentString, 'opera mini') !== false) {
            $resultant = stristr($this->userAgentString, 'opera mini');
            if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', $resultant);
                $aversion = explode(' ', $aresult[1]);
                $this->setBrowserVersionString($aversion[0]);
            } else {
                $aversion = explode(' ', stristr($resultant, 'opera mini'));
                $this->setBrowserVersionString($aversion[1]);
            }
            $this->browser = self::BROWSER_OPERA_MINI;
            $this->mobile = true;
            return true;
        } else if (stripos($this->userAgentString, 'opera') !== false) {
            $resultant = stristr($this->userAgentString, 'opera');
            if (preg_match('/Version\/(10.*)$/', $resultant, $matches)) {
                $this->setBrowserVersionString($matches[1]);
            } else if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', str_replace('(', ' ', $resultant));
                $aversion = explode(' ', $aresult[1]);
                $this->setBrowserVersionString($aversion[0]);
            } else {
                $aversion = explode(' ', stristr($resultant, 'opera'));
                $this->setBrowserVersionString(isset($aversion[1]) ? $aversion[1] : '');
            }
            $this->browser = self::BROWSER_OPERA;
            return true;
        }
        return false;
    }

    private function checkBrowserChrome() {
        if (stripos($this->userAgentString, 'Chrome') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Chrome'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_CHROME;
            return true;
        }
        return false;
    }

    private function checkBrowserWebTv() {
        if (stripos($this->userAgentString, 'webtv') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'webtv'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_WEBTV;
            return true;
        }
        return false;
    }

    private function checkBrowserNetPositive() {
        if (stripos($this->userAgentString, 'NetPositive') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'NetPositive'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString(str_replace(array('(', ')', ';'), '', $aversion[0]));
            $this->browser = self::BROWSER_NETPOSITIVE;
            return true;
        }
        return false;
    }

    private function checkBrowserGaleon() {
        if (stripos($this->userAgentString, 'galeon') !== false) {
            $aresult = explode(' ', stristr($this->userAgentString, 'galeon'));
            $aversion = explode('/', $aresult[0]);
            $this->setBrowserVersionString($aversion[1]);
            $this->browser = self::BROWSER_GALEON;
            return true;
        }
        return false;
    }

    private function checkBrowserKonqueror() {
        if (stripos($this->userAgentString, 'Konqueror') !== false) {
            $aresult = explode(' ', stristr($this->userAgentString, 'Konqueror'));
            $aversion = explode('/', $aresult[0]);
            $this->setBrowserVersionString($aversion[1]);
            $this->browser = self::BROWSER_KONQUEROR;
            return true;
        }
        return false;
    }

    private function checkBrowserIcab() {
        if (stripos($this->userAgentString, 'icab') !== false) {
            $aversion = explode(' ', stristr(str_replace('/', ' ', $this->userAgentString), 'icab'));
            $this->setBrowserVersionString($aversion[1]);
            $this->browser = self::BROWSER_ICAB;
            return true;
        }
        return false;
    }

    private function checkBrowserOmniWeb() {
        if (stripos($this->userAgentString, 'omniweb') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'omniweb'));
            $aversion = explode(' ', isset($aresult[1]) ? $aresult[1] : '');
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_OMNIWEB;
            return true;
        }
        return false;
    }

    private function checkBrowserPhoenix() {
        if (stripos($this->userAgentString, 'Phoenix') !== false) {
            $aversion = explode('/', stristr($this->userAgentString, 'Phoenix'));
            $this->setBrowserVersionString($aversion[1]);
            $this->browser = self::BROWSER_PHOENIX;
            return true;
        }
        return false;
    }

    private function checkBrowserFirebird() {
        if (stripos($this->userAgentString, 'Firebird') !== false) {
            $aversion = explode('/', stristr($this->userAgentString, 'Firebird'));
            $this->setBrowserVersionString($aversion[1]);
            $this->browser = self::BROWSER_FIREBIRD;
            return true;
        }
        return false;
    }

    private function checkBrowserNetscapeNavigator9Plus() {
        if (stripos($this->userAgentString, 'Firefox') !== false && preg_match('/Navigator\/([^ ]*)/i', $this->userAgentString, $matches)) {
            $this->setBrowserVersionString($matches[1]);
            $this->browser = self::BROWSER_NETSCAPE_NAVIGATOR;
            return true;
        } else if (stripos($this->userAgentString, 'Firefox') === false && preg_match('/Netscape6?\/([^ ]*)/i', $this->userAgentString, $matches)) {
            $this->setBrowserVersionString($matches[1]);
            $this->browser = self::BROWSER_NETSCAPE_NAVIGATOR;
            return true;
        }
        return false;
    }

    private function checkBrowserShiretoko() {
        if (stripos($this->userAgentString, 'Mozilla') !== false && preg_match('/Shiretoko\/([^ ]*)/i', $this->userAgentString, $matches)) {
            $this->setBrowserVersionString($matches[1]);
            $this->browser = self::BROWSER_SHIRETOKO;
            return true;
        }
        return false;
    }

    private function checkBrowserIceCat() {
        if (stripos($this->userAgentString, 'Mozilla') !== false && preg_match('/IceCat\/([^ ]*)/i', $this->userAgentString, $matches)) {
            $this->setBrowserVersionString($matches[1]);
            $this->browser = self::BROWSER_ICECAT;
            return true;
        }
        return false;
    }

    private function checkBrowserNokia() {
        if (preg_match('/Nokia([^\/]+)\/([^ SP]+)/i', $this->userAgentString, $matches)) {
            $this->setBrowserVersionString($matches[2]);
            if (stripos($this->userAgentString, 'Series60') !== false || strpos($this->userAgentString, 'S60') !== false) {
                $this->browser = self::BROWSER_NOKIA_S60;
            } else {
                $this->browser = self::BROWSER_NOKIA;
            }
            $this->mobile = true;
            return true;
        }
        return false;
    }

    private function checkBrowserFirefox() {
        if (stripos($this->userAgentString, 'safari') === false) {
            if (preg_match('/Firefox[\/ \(]([^ ;\)]+)/i', $this->userAgentString, $matches)) {
                $this->setBrowserVersionString($matches[1]);
                $this->browser = self::BROWSER_FIREFOX;
                return true;
            } else if (preg_match('/Firefox$/i', $this->userAgentString, $matches)) {
                $this->browser = self::BROWSER_FIREFOX;
                return true;
            }
        }
        return false;
    }

    private function checkBrowserIceweasel() {
        if (stripos($this->userAgentString, 'Iceweasel') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Iceweasel'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_ICEWEASEL;
            return true;
        }
        return false;
    }

    private function checkBrowserMozilla() {
        if (stripos($this->userAgentString, 'mozilla') !== false && preg_match('/rv:[0-9].[0-9][a-b]?/i', $this->userAgentString) && stripos($this->userAgentString, 'netscape') === false) {
            $aversion = explode(' ', stristr($this->userAgentString, 'rv:'));
            preg_match('/rv:[0-9].[0-9][a-b]?/i', $this->userAgentString, $aversion);
            $this->setBrowserVersionString(str_replace('rv:', '', $aversion[0]));
            $this->browser = self::BROWSER_MOZILLA;
            return true;
        } else if (stripos($this->userAgentString, 'mozilla') !== false && preg_match('/rv:[0-9]\.[0-9]/i', $this->userAgentString) && stripos($this->userAgentString, 'netscape') === false) {
            $aversion = explode('', stristr($this->userAgentString, 'rv:'));
            $this->setBrowserVersionString(str_replace('rv:', '', $aversion[0]));
            $this->browser = self::BROWSER_MOZILLA;
            return true;
        } else if (stripos($this->userAgentString, 'mozilla') !== false && preg_match('/mozilla\/([^ ]*)/i', $this->userAgentString, $matches) && stripos($this->userAgentString, 'netscape') === false) {
            $this->setBrowserVersionString($matches[1]);
            $this->browser = self::BROWSER_MOZILLA;
            return true;
        }
        return false;
    }

    private function checkBrowserLynx() {
        if (stripos($this->userAgentString, 'lynx') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Lynx'));
            $aversion = explode(' ', (isset($aresult[1]) ? $aresult[1] : ''));
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_LYNX;
            return true;
        }
        return false;
    }

    private function checkBrowserAmaya() {
        if (stripos($this->userAgentString, 'amaya') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Amaya'));
            $aversion = explode(' ', $aresult[1]);
            $this->setBrowserVersionString($aversion[0]);
            $this->browser = self::BROWSER_AMAYA;
            return true;
        }
        return false;
    }

    private function checkBrowserSafari() {
        if (stripos($this->userAgentString, 'Safari') !== false && stripos($this->userAgentString, 'iPhone') === false && stripos($this->userAgentString, 'iPod') === false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setBrowserVersionString($aversion[0]);
            }
            $this->browser = self::BROWSER_SAFARI;
            return true;
        }
        return false;
    }

    private function checkBrowseriPhone() {
        if (stripos($this->userAgentString, 'iPhone') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setBrowserVersionString($aversion[0]);
            }
            $this->mobile = true;
            $this->browser = self::BROWSER_IPHONE;
            return true;
        }
        return false;
    }

    private function checkBrowseriPad() {
        if (stripos($this->userAgentString, 'iPad') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setBrowserVersionString($aversion[0]);
            }
            $this->mobile = true;
            $this->browser = self::BROWSER_IPAD;
            return true;
        }
        return false;
    }

    private function checkBrowseriPod() {
        if (stripos($this->userAgentString, 'iPod') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setBrowserVersionString($aversion[0]);
            }
            $this->mobile = true;
            $this->browser = self::BROWSER_IPOD;
            return true;
        }
        return false;
    }

    private function checkBrowserAndroid() {
        if (stripos($this->userAgentString, 'Android') !== false) {
            $aresult = explode('/', stristr($this->userAgentString, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setBrowserVersionString($aversion[0]);
            }
            $this->mobile = true;
            $this->browser = self::BROWSER_ANDROID;
            return true;
        }
        return false;
    }

}
?>
