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
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class HttpUserAgentImpl extends Object implements Cloneable, \blaze\netlet\http\HttpUserAgent {

    private $browser = self::BROWSER_UNKNOWN;
    private $browserMajorVersion = 0;
    private $browserMinorVersion = 0;
    private $cssVersion = 0;
    private $htmlVersion = 0;
    private $robot = false;
    private $mobile = false;
    private $operatingSystem = self::OS_UNKNOWN;
    private $userAgentString;

    /**
     *
     * @param blaze\lang\String|string $userAgent The user agent string
     */
    public function __construct($userAgent) {
        $this->userAgentString = String::asWrapper($userAgent);
        var_dump(get_browser($useragent));
    }

    public function getBrowser() {

    }

    public function getBrowserMajorVersion() {

    }

    public function getBrowserMinorVersion() {

    }

    public function getCssVersion() {

    }

    public function getHtmlVersion() {

    }

    public function getOperatingSystem() {

    }

    public function getUserAgentString() {
        return $this->userAgentString;
    }

    /**
	     * Determine if the user is using a BlackBerry (last updated 1.7)
	     * @return boolean True if the browser is the BlackBerry browser otherwise false
	     */
	    protected function checkBrowserBlackBerry() {
		    if( stripos($this->_agent,'blackberry') !== false ) {
			    $aresult = explode("/",stristr($this->_agent,"BlackBerry"));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion($aversion[0]);
			    $this->_browser_name = self::BROWSER_BLACKBERRY;
			    $this->setMobile(true);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the user is using an AOL User Agent (last updated 1.7)
	     * @return boolean True if the browser is from AOL otherwise false
             * @todo versionen testen mit AOL-agent string
	     */
	    protected function checkBrowserAol() {
			if( stripos($this->_agent,'aol') !== false ) {
			    $aversion = explode(' ',stristr($this->_agent, 'AOL'));
			    $this->_browser_name = self::BROWSER_AOL;
			    $this->browserMajorVersion;//(preg_replace('/[^0-9\.a-z]/i', '', $aversion[1]));
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is the GoogleBot or not (last updated 1.7)
	     * @return boolean True if the browser is the GoogletBot otherwise false
	     */
	    protected function checkBrowserGoogleBot() {
		    if( stripos($this->_agent,'googlebot') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'googlebot'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion(str_replace(';','',$aversion[0]));
				$this->_browser_name = self::BROWSER_GOOGLEBOT;
				$this->setRobot(true);
				return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is the W3C Validator or not (last updated 1.7)
	     * @return boolean True if the browser is the W3C Validator otherwise false
	     */
	    protected function checkBrowserW3CValidator() {
		    if( stripos($this->_agent,'W3C-checklink') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'W3C-checklink'));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion($aversion[0]);
			    $this->_browser_name = self::BROWSER_W3CVALIDATOR;
			    return true;
		    }
		    else if( stripos($this->_agent,'W3C_Validator') !== false ) {
				// Some of the Validator versions do not delineate w/ a slash - add it back in
				$ua = str_replace("W3C_Validator ", "W3C_Validator/", $this->_agent);
			    $aresult = explode('/',stristr($ua,'W3C_Validator'));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion($aversion[0]);
			    $this->_browser_name = self::BROWSER_W3CVALIDATOR;
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is the Yahoo! Slurp Robot or not (last updated 1.7)
	     * @return boolean True if the browser is the Yahoo! Slurp Robot otherwise false
	     */
	    protected function checkBrowserSlurp() {
		    if( stripos($this->_agent,'slurp') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Slurp'));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion($aversion[0]);
			    $this->_browser_name = self::BROWSER_SLURP;
				$this->setRobot(true);
				$this->setMobile(false);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Internet Explorer or not (last updated 1.7)
	     * @return boolean True if the browser is Internet Explorer otherwise false
	     */
	    protected function checkBrowserInternetExplorer() {

		    // Test for v1 - v1.5 IE
		    if( stripos($this->_agent,'microsoft internet explorer') !== false ) {
			    $this->setBrowser(self::BROWSER_IE);
			    $this->setVersion('1.0');
			    $aresult = stristr($this->_agent, '/');
			    if( preg_match('/308|425|426|474|0b1/i', $aresult) ) {
				    $this->setVersion('1.5');
			    }
				return true;
		    }
		    // Test for versions > 1.5
		    else if( stripos($this->_agent,'msie') !== false && stripos($this->_agent,'opera') === false ) {
			    $aresult = explode(' ',stristr(str_replace(';','; ',$this->_agent),'msie'));
			    $this->setBrowser( self::BROWSER_IE );
			    $this->setVersion(str_replace(array('(',')',';'),'',$aresult[1]));
			    return true;
		    }
		    // Test for Pocket IE
		    else if( stripos($this->_agent,'mspie') !== false || stripos($this->_agent,'pocket') !== false ) {
			    $aresult = explode(' ',stristr($this->_agent,'mspie'));
			    $this->setPlatform( self::PLATFORM_WINDOWS_CE );
			    $this->setBrowser( self::BROWSER_POCKET_IE );
			    $this->setMobile(true);

			    if( stripos($this->_agent,'mspie') !== false ) {
				    $this->setVersion($aresult[1]);
			    }
			    else {
				    $aversion = explode('/',$this->_agent);
				    $this->setVersion($aversion[1]);
			    }
			    return true;
		    }
			return false;
	    }

	    /**
	     * Determine if the browser is Opera or not (last updated 1.7)
	     * @return boolean True if the browser is Opera otherwise false
	     */
	    protected function checkBrowserOpera() {
		    if( stripos($this->_agent,'opera mini') !== false ) {
			    $resultant = stristr($this->_agent, 'opera mini');
			    if( preg_match('/\//',$resultant) ) {
				    $aresult = explode('/',$resultant);
				    $aversion = explode(' ',$aresult[1]);
				    $this->setVersion($aversion[0]);
				}
			    else {
				    $aversion = explode(' ',stristr($resultant,'opera mini'));
				    $this->setVersion($aversion[1]);
			    }
			    $this->_browser_name = self::BROWSER_OPERA_MINI;
				$this->setMobile(true);
				return true;
		    }
		    else if( stripos($this->_agent,'opera') !== false ) {
			    $resultant = stristr($this->_agent, 'opera');
			    if( preg_match('/Version\/(10.*)$/',$resultant,$matches) ) {
				    $this->setVersion($matches[1]);
			    }
			    else if( preg_match('/\//',$resultant) ) {
				    $aresult = explode('/',str_replace("("," ",$resultant));
				    $aversion = explode(' ',$aresult[1]);
				    $this->setVersion($aversion[0]);
			    }
			    else {
				    $aversion = explode(' ',stristr($resultant,'opera'));
				    $this->setVersion(isset($aversion[1])?$aversion[1]:"");
			    }
			    $this->_browser_name = self::BROWSER_OPERA;
			    return true;
		    }
			return false;
	    }

	    /**
	     * Determine if the browser is Chrome or not (last updated 1.7)
	     * @return boolean True if the browser is Chrome otherwise false
	     */
	    protected function checkBrowserChrome() {
		    if( stripos($this->_agent,'Chrome') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Chrome'));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion($aversion[0]);
			    $this->setBrowser(self::BROWSER_CHROME);
			    return true;
		    }
		    return false;
	    }


	    /**
	     * Determine if the browser is WebTv or not (last updated 1.7)
	     * @return boolean True if the browser is WebTv otherwise false
	     */
	    protected function checkBrowserWebTv() {
		    if( stripos($this->_agent,'webtv') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'webtv'));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion($aversion[0]);
			    $this->setBrowser(self::BROWSER_WEBTV);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is NetPositive or not (last updated 1.7)
	     * @return boolean True if the browser is NetPositive otherwise false
	     */
	    protected function checkBrowserNetPositive() {
		    if( stripos($this->_agent,'NetPositive') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'NetPositive'));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion(str_replace(array('(',')',';'),'',$aversion[0]));
			    $this->setBrowser(self::BROWSER_NETPOSITIVE);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Galeon or not (last updated 1.7)
	     * @return boolean True if the browser is Galeon otherwise false
	     */
	    protected function checkBrowserGaleon() {
		    if( stripos($this->_agent,'galeon') !== false ) {
			    $aresult = explode(' ',stristr($this->_agent,'galeon'));
			    $aversion = explode('/',$aresult[0]);
			    $this->setVersion($aversion[1]);
			    $this->setBrowser(self::BROWSER_GALEON);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Konqueror or not (last updated 1.7)
	     * @return boolean True if the browser is Konqueror otherwise false
	     */
	    protected function checkBrowserKonqueror() {
		    if( stripos($this->_agent,'Konqueror') !== false ) {
			    $aresult = explode(' ',stristr($this->_agent,'Konqueror'));
			    $aversion = explode('/',$aresult[0]);
			    $this->setVersion($aversion[1]);
			    $this->setBrowser(self::BROWSER_KONQUEROR);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is iCab or not (last updated 1.7)
	     * @return boolean True if the browser is iCab otherwise false
	     */
	    protected function checkBrowserIcab() {
		    if( stripos($this->_agent,'icab') !== false ) {
			    $aversion = explode(' ',stristr(str_replace('/',' ',$this->_agent),'icab'));
			    $this->setVersion($aversion[1]);
			    $this->setBrowser(self::BROWSER_ICAB);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is OmniWeb or not (last updated 1.7)
	     * @return boolean True if the browser is OmniWeb otherwise false
	     */
	    protected function checkBrowserOmniWeb() {
		    if( stripos($this->_agent,'omniweb') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'omniweb'));
			    $aversion = explode(' ',isset($aresult[1])?$aresult[1]:"");
			    $this->setVersion($aversion[0]);
			    $this->setBrowser(self::BROWSER_OMNIWEB);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Phoenix or not (last updated 1.7)
	     * @return boolean True if the browser is Phoenix otherwise false
	     */
	    protected function checkBrowserPhoenix() {
		    if( stripos($this->_agent,'Phoenix') !== false ) {
			    $aversion = explode('/',stristr($this->_agent,'Phoenix'));
			    $this->setVersion($aversion[1]);
			    $this->setBrowser(self::BROWSER_PHOENIX);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Firebird or not (last updated 1.7)
	     * @return boolean True if the browser is Firebird otherwise false
	     */
	    protected function checkBrowserFirebird() {
		    if( stripos($this->_agent,'Firebird') !== false ) {
			    $aversion = explode('/',stristr($this->_agent,'Firebird'));
			    $this->setVersion($aversion[1]);
			    $this->setBrowser(self::BROWSER_FIREBIRD);
				return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Netscape Navigator 9+ or not (last updated 1.7)
		 * NOTE: (http://browser.netscape.com/ - Official support ended on March 1st, 2008)
	     * @return boolean True if the browser is Netscape Navigator 9+ otherwise false
	     */
	    protected function checkBrowserNetscapeNavigator9Plus() {
		    if( stripos($this->_agent,'Firefox') !== false && preg_match('/Navigator\/([^ ]*)/i',$this->_agent,$matches) ) {
			    $this->setVersion($matches[1]);
			    $this->setBrowser(self::BROWSER_NETSCAPE_NAVIGATOR);
			    return true;
		    }
		    else if( stripos($this->_agent,'Firefox') === false && preg_match('/Netscape6?\/([^ ]*)/i',$this->_agent,$matches) ) {
			    $this->setVersion($matches[1]);
			    $this->setBrowser(self::BROWSER_NETSCAPE_NAVIGATOR);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Shiretoko or not (https://wiki.mozilla.org/Projects/shiretoko) (last updated 1.7)
	     * @return boolean True if the browser is Shiretoko otherwise false
	     */
	    protected function checkBrowserShiretoko() {
		    if( stripos($this->_agent,'Mozilla') !== false && preg_match('/Shiretoko\/([^ ]*)/i',$this->_agent,$matches) ) {
			    $this->setVersion($matches[1]);
			    $this->setBrowser(self::BROWSER_SHIRETOKO);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Ice Cat or not (http://en.wikipedia.org/wiki/GNU_IceCat) (last updated 1.7)
	     * @return boolean True if the browser is Ice Cat otherwise false
	     */
	    protected function checkBrowserIceCat() {
		    if( stripos($this->_agent,'Mozilla') !== false && preg_match('/IceCat\/([^ ]*)/i',$this->_agent,$matches) ) {
			    $this->setVersion($matches[1]);
			    $this->setBrowser(self::BROWSER_ICECAT);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Nokia or not (last updated 1.7)
	     * @return boolean True if the browser is Nokia otherwise false
	     */
	    protected function checkBrowserNokia() {
		    if( preg_match("/Nokia([^\/]+)\/([^ SP]+)/i",$this->_agent,$matches) ) {
			    $this->setVersion($matches[2]);
				if( stripos($this->_agent,'Series60') !== false || strpos($this->_agent,'S60') !== false ) {
					$this->setBrowser(self::BROWSER_NOKIA_S60);
				}
				else {
					$this->setBrowser( self::BROWSER_NOKIA );
				}
			    $this->setMobile(true);
			    return true;
		    }
			return false;
	    }

	    /**
	     * Determine if the browser is Firefox or not (last updated 1.7)
	     * @return boolean True if the browser is Firefox otherwise false
	     */
	    protected function checkBrowserFirefox() {
		    if( stripos($this->_agent,'safari') === false ) {
				if( preg_match("/Firefox[\/ \(]([^ ;\)]+)/i",$this->_agent,$matches) ) {
					$this->setVersion($matches[1]);
					$this->setBrowser(self::BROWSER_FIREFOX);
					return true;
				}
				else if( preg_match("/Firefox$/i",$this->_agent,$matches) ) {
					$this->setVersion("");
					$this->setBrowser(self::BROWSER_FIREFOX);
					return true;
				}
			}
		    return false;
	    }

		/**
	     * Determine if the browser is Firefox or not (last updated 1.7)
	     * @return boolean True if the browser is Firefox otherwise false
	     */
	    protected function checkBrowserIceweasel() {
			if( stripos($this->_agent,'Iceweasel') !== false ) {
				$aresult = explode('/',stristr($this->_agent,'Iceweasel'));
				$aversion = explode(' ',$aresult[1]);
				$this->setVersion($aversion[0]);
				$this->setBrowser(self::BROWSER_ICEWEASEL);
				return true;
			}
			return false;
		}
	    /**
	     * Determine if the browser is Mozilla or not (last updated 1.7)
	     * @return boolean True if the browser is Mozilla otherwise false
	     */
	    protected function checkBrowserMozilla() {
		    if( stripos($this->_agent,'mozilla') !== false  && preg_match('/rv:[0-9].[0-9][a-b]?/i',$this->_agent) && stripos($this->_agent,'netscape') === false) {
			    $aversion = explode(' ',stristr($this->_agent,'rv:'));
			    preg_match('/rv:[0-9].[0-9][a-b]?/i',$this->_agent,$aversion);
			    $this->setVersion(str_replace('rv:','',$aversion[0]));
			    $this->setBrowser(self::BROWSER_MOZILLA);
			    return true;
		    }
		    else if( stripos($this->_agent,'mozilla') !== false && preg_match('/rv:[0-9]\.[0-9]/i',$this->_agent) && stripos($this->_agent,'netscape') === false ) {
			    $aversion = explode('',stristr($this->_agent,'rv:'));
			    $this->setVersion(str_replace('rv:','',$aversion[0]));
			    $this->setBrowser(self::BROWSER_MOZILLA);
			    return true;
		    }
		    else if( stripos($this->_agent,'mozilla') !== false  && preg_match('/mozilla\/([^ ]*)/i',$this->_agent,$matches) && stripos($this->_agent,'netscape') === false ) {
			    $this->setVersion($matches[1]);
			    $this->setBrowser(self::BROWSER_MOZILLA);
			    return true;
		    }
			return false;
	    }

	    /**
	     * Determine if the browser is Lynx or not (last updated 1.7)
	     * @return boolean True if the browser is Lynx otherwise false
	     */
	    protected function checkBrowserLynx() {
		    if( stripos($this->_agent,'lynx') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Lynx'));
			    $aversion = explode(' ',(isset($aresult[1])?$aresult[1]:""));
			    $this->setVersion($aversion[0]);
			    $this->setBrowser(self::BROWSER_LYNX);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Amaya or not (last updated 1.7)
	     * @return boolean True if the browser is Amaya otherwise false
	     */
	    protected function checkBrowserAmaya() {
		    if( stripos($this->_agent,'amaya') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Amaya'));
			    $aversion = explode(' ',$aresult[1]);
			    $this->setVersion($aversion[0]);
			    $this->setBrowser(self::BROWSER_AMAYA);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Safari or not (last updated 1.7)
	     * @return boolean True if the browser is Safari otherwise false
	     */
	    protected function checkBrowserSafari() {
		    if( stripos($this->_agent,'Safari') !== false && stripos($this->_agent,'iPhone') === false && stripos($this->_agent,'iPod') === false ) {
			    $aresult = explode('/',stristr($this->_agent,'Version'));
			    if( isset($aresult[1]) ) {
				    $aversion = explode(' ',$aresult[1]);
				    $this->setVersion($aversion[0]);
			    }
			    else {
				    $this->setVersion(self::VERSION_UNKNOWN);
			    }
			    $this->setBrowser(self::BROWSER_SAFARI);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is iPhone or not (last updated 1.7)
	     * @return boolean True if the browser is iPhone otherwise false
	     */
	    protected function checkBrowseriPhone() {
		    if( stripos($this->_agent,'iPhone') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Version'));
			    if( isset($aresult[1]) ) {
				    $aversion = explode(' ',$aresult[1]);
				    $this->setVersion($aversion[0]);
			    }
			    else {
				    $this->setVersion(self::VERSION_UNKNOWN);
			    }
			    $this->setMobile(true);
			    $this->setBrowser(self::BROWSER_IPHONE);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is iPod or not (last updated 1.7)
	     * @return boolean True if the browser is iPod otherwise false
	     */
	    protected function checkBrowseriPad() {
		    if( stripos($this->_agent,'iPad') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Version'));
			    if( isset($aresult[1]) ) {
				    $aversion = explode(' ',$aresult[1]);
				    $this->setVersion($aversion[0]);
			    }
			    else {
				    $this->setVersion(self::VERSION_UNKNOWN);
			    }
			    $this->setMobile(true);
			    $this->setBrowser(self::BROWSER_IPAD);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is iPod or not (last updated 1.7)
	     * @return boolean True if the browser is iPod otherwise false
	     */
	    protected function checkBrowseriPod() {
		    if( stripos($this->_agent,'iPod') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Version'));
			    if( isset($aresult[1]) ) {
				    $aversion = explode(' ',$aresult[1]);
				    $this->setVersion($aversion[0]);
			    }
			    else {
				    $this->setVersion(self::VERSION_UNKNOWN);
			    }
			    $this->setMobile(true);
			    $this->setBrowser(self::BROWSER_IPOD);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine if the browser is Android or not (last updated 1.7)
	     * @return boolean True if the browser is Android otherwise false
	     */
	    protected function checkBrowserAndroid() {
		    if( stripos($this->_agent,'Android') !== false ) {
			    $aresult = explode('/',stristr($this->_agent,'Version'));
			    if( isset($aresult[1]) ) {
				    $aversion = explode(' ',$aresult[1]);
				    $this->setVersion($aversion[0]);
			    }
			    else {
				    $this->setVersion(self::VERSION_UNKNOWN);
			    }
			    $this->setMobile(true);
			    $this->setBrowser(self::BROWSER_ANDROID);
			    return true;
		    }
		    return false;
	    }

	    /**
	     * Determine the user's platform (last updated 1.7)
	     */
	    protected function checkPlatform() {
		    if( stripos($this->_agent, 'windows') !== false ) {
			    $this->_platform = self::PLATFORM_WINDOWS;
		    }
		    else if( stripos($this->_agent, 'iPad') !== false ) {
			    $this->_platform = self::PLATFORM_IPAD;
		    }
		    else if( stripos($this->_agent, 'iPod') !== false ) {
			    $this->_platform = self::PLATFORM_IPOD;
		    }
		    else if( stripos($this->_agent, 'iPhone') !== false ) {
			    $this->_platform = self::PLATFORM_IPHONE;
		    }
		    elseif( stripos($this->_agent, 'mac') !== false ) {
			    $this->_platform = self::PLATFORM_APPLE;
		    }
		    elseif( stripos($this->_agent, 'linux') !== false ) {
			    $this->_platform = self::PLATFORM_LINUX;
		    }
		    else if( stripos($this->_agent, 'Nokia') !== false ) {
			    $this->_platform = self::PLATFORM_NOKIA;
		    }
		    else if( stripos($this->_agent, 'BlackBerry') !== false ) {
			    $this->_platform = self::PLATFORM_BLACKBERRY;
		    }
		    elseif( stripos($this->_agent,'FreeBSD') !== false ) {
			    $this->_platform = self::PLATFORM_FREEBSD;
		    }
		    elseif( stripos($this->_agent,'OpenBSD') !== false ) {
			    $this->_platform = self::PLATFORM_OPENBSD;
		    }
		    elseif( stripos($this->_agent,'NetBSD') !== false ) {
			    $this->_platform = self::PLATFORM_NETBSD;
		    }
		    elseif( stripos($this->_agent, 'OpenSolaris') !== false ) {
			    $this->_platform = self::PLATFORM_OPENSOLARIS;
		    }
		    elseif( stripos($this->_agent, 'SunOS') !== false ) {
			    $this->_platform = self::PLATFORM_SUNOS;
		    }
		    elseif( stripos($this->_agent, 'OS\/2') !== false ) {
			    $this->_platform = self::PLATFORM_OS2;
		    }
		    elseif( stripos($this->_agent, 'BeOS') !== false ) {
			    $this->_platform = self::PLATFORM_BEOS;
		    }
		    elseif( stripos($this->_agent, 'win') !== false ) {
			    $this->_platform = self::PLATFORM_WINDOWS;
		    }

	    }

}
?>
