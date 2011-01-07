<?php

namespace blaze\netlet\http;

use blaze\lang\Cloneable;

/**
 * Description of HttpUserAgent
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface HttpUserAgent extends Cloneable {
    const BROWSER_UNKNOWN = 'unknown';

    const BROWSER_OPERA = 'Opera';                            // http://www.opera.com/
    const BROWSER_OPERA_MINI = 'Opera Mini';                  // http://www.opera.com/mini/
    const BROWSER_WEBTV = 'WebTV';                            // http://www.webtv.net/pc/
    const BROWSER_IE = 'Internet Explorer';                   // http://www.microsoft.com/ie/
    const BROWSER_POCKET_IE = 'Pocket Internet Explorer';     // http://en.wikipedia.org/wiki/Internet_Explorer_Mobile
    const BROWSER_KONQUEROR = 'Konqueror';                    // http://www.konqueror.org/
    const BROWSER_ICAB = 'iCab';                              // http://www.icab.de/
    const BROWSER_OMNIWEB = 'OmniWeb';                        // http://www.omnigroup.com/applications/omniweb/
    const BROWSER_FIREBIRD = 'Firebird';                      // http://www.ibphoenix.com/
    const BROWSER_FIREFOX = 'Firefox';                        // http://www.mozilla.com/en-US/firefox/firefox.html
    const BROWSER_ICEWEASEL = 'Iceweasel';                    // http://www.geticeweasel.org/
    const BROWSER_SHIRETOKO = 'Shiretoko';                    // http://wiki.mozilla.org/Projects/shiretoko
    const BROWSER_MOZILLA = 'Mozilla';                        // http://www.mozilla.com/en-US/
    const BROWSER_AMAYA = 'Amaya';                            // http://www.w3.org/Amaya/
    const BROWSER_LYNX = 'Lynx';                              // http://en.wikipedia.org/wiki/Lynx
    const BROWSER_SAFARI = 'Safari';                          // http://apple.com
    const BROWSER_IPHONE = 'iPhone';                          // http://apple.com
    const BROWSER_IPOD = 'iPod';                              // http://apple.com
    const BROWSER_IPAD = 'iPad';                              // http://apple.com
    const BROWSER_CHROME = 'Chrome';                          // http://www.google.com/chrome
    const BROWSER_ANDROID = 'Android';                        // http://www.android.com/
    const BROWSER_GOOGLEBOT = 'GoogleBot';                    // http://en.wikipedia.org/wiki/Googlebot
    const BROWSER_SLURP = 'Yahoo! Slurp';                     // http://en.wikipedia.org/wiki/Yahoo!_Slurp
    const BROWSER_W3CVALIDATOR = 'W3C Validator';             // http://validator.w3.org/
    const BROWSER_BLACKBERRY = 'BlackBerry';                  // http://www.blackberry.com/
    const BROWSER_ICECAT = 'IceCat';                          // http://en.wikipedia.org/wiki/GNU_IceCat
    const BROWSER_NOKIA_S60 = 'Nokia S60 OSS Browser';        // http://en.wikipedia.org/wiki/Web_Browser_for_S60
    const BROWSER_NOKIA = 'Nokia Browser';                    // * all other WAP-based browsers on the Nokia Platform

    const BROWSER_NETSCAPE_NAVIGATOR = 'Netscape Navigator';  // http://browser.netscape.com/ (DEPRECATED)
    const BROWSER_GALEON = 'Galeon';                          // http://galeon.sourceforge.net/ (DEPRECATED)
    const BROWSER_NETPOSITIVE = 'NetPositive';                // http://en.wikipedia.org/wiki/NetPositive (DEPRECATED)
    const BROWSER_PHOENIX = 'Phoenix';                        // http://en.wikipedia.org/wiki/History_of_Mozilla_Firefox (DEPRECATED)

    const OS_WINDOWS = 'Windows';
    const OS_WINDOWS_CE = 'Windows CE';
    const OS_APPLE = 'Apple';
    const OS_LINUX = 'Linux';
    const OS_OS2 = 'OS/2';
    const OS_BEOS = 'BeOS';
    const OS_IPHONE = 'iPhone';
    const OS_IPOD = 'iPod';
    const OS_IPAD = 'iPad';
    const OS_BLACKBERRY = 'BlackBerry';
    const OS_NOKIA = 'Nokia';
    const OS_FREEBSD = 'FreeBSD';
    const OS_OPENBSD = 'OpenBSD';
    const OS_NETBSD = 'NetBSD';
    const OS_SUNOS = 'SunOS';
    const OS_OPENSOLARIS = 'OpenSolaris';

    const OS_UNKNOWN = 'unknown';

    public function getUserAgentString();

    public function getBrowser();

    public function getBrowserMajorVersion();

    public function getBrowserMinorVersion();

    public function getBrowserVersionString();

    public function getOperatingSystem();

    public function getHtmlVersion();

    public function getCssVersion();

    public function isMobile();

    public function isRobot();
}

?>
