<?php

namespace blaze\net;

use blaze\lang\Object;

/**
 * Description of URL
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
final class URL extends Object implements \blaze\lang\Comparable, \blaze\io\Serializable, \blaze\lang\StaticInitialization {

    /**
     *
     * @var blaze\lang\String
     */
    private $scheme;
    /**
     *
     * @var blaze\lang\String
     */
    private $user;
    /**
     *
     * @var blaze\lang\String
     */
    private $password;
    /**
     *
     * @var blaze\lang\String
     */
    private $host;
    /**
     *
     * @var int
     */
    private $port = -1;
    /**
     *
     * @var blaze\lang\String
     */
    private $path;
    /**
     *
     * @var blaze\lang\String
     */
    private $query;
    /**
     *
     * @var blaze\lang\String
     */
    private $fragment;
    /**
     *
     * @var blaze\lang\String
     */
    private $urlString;
    /**
     *
     * @var int
     */
    private $hashCode;
    /**
     *
     * @var blaze\net\URLStreamHandler
     */
    private $handler;
    /**
     *
     * @var blaze\collections\Map
     */
    private static $handlers;
    /**
     *
     * @var blaze\net\URLStreamHandlerFactory
     */
    private static $factory;

    public static function staticInit() {
        self::$handlers = new \blaze\collections\map\HashMap();
    }

    /**
     *
     * @param blaze\lang\String|string $scheme
     * @param blaze\lang\String|string $user
     * @param blaze\lang\String|string $password
     * @param blaze\lang\String|string $host
     * @param int $port
     * @param blaze\lang\String|string $path
     * @param blaze\lang\String|string $query
     * @param blaze\lang\String|string $fragment
     */
    public function __construct($scheme, $user = null, $password = null, $host = null, $port = null, $path = null, $query = null, $fragment = null) {
        $this->scheme = $scheme !== null ? \blaze\lang\String::asWrapper($scheme) : null;
        $this->user = $user !== null ? \blaze\lang\String::asWrapper($user) : null;
        $this->password = $password !== null ? \blaze\lang\String::asWrapper($password) : null;
        $this->host = $host !== null ? \blaze\lang\String::asWrapper($host) : null;
        $this->port = $port !== null ? \blaze\lang\Integer::asNative($port) : -1;
        $this->path = $path !== null ? \blaze\lang\String::asWrapper($path) : null;
        $this->query = $query !== null ? \blaze\lang\String::asWrapper($query) : null;
        $this->fragment = $fragment !== null ? \blaze\lang\String::asWrapper($fragment) : null;
        $this->buildUrl();
    }

    /**
     * Description
     *
     * @param 	blaze\lang\String|string $url Description of the parameter $var
     * @return 	blaze\net\URL Description of what the method returns
     * @throws	blaze\lang\Exception
     */
    public static function parseURL(\blaze\lang\String $url) {
        $idx = $url->indexOf('://');

        if ($idx == -1)
            throw new \blaze\lang\Exception('Invalid URL');

        $parts = parse_url($url);

        if ($parts === false)
            throw new \blaze\lang\Exception('Invalid URL');

        $scheme = isset($parts['scheme']) ? $parts['scheme'] : null;
        $host = isset($parts['host']) ? $parts['host'] : null;
        $port = isset($parts['port']) ? $parts['port'] : null;
        $user = isset($parts['user']) ? $parts['user'] : null;
        $password = isset($parts['pass']) ? $parts['pass'] : null;
        $path = isset($parts['path']) ? $parts['path'] : null;
        $query = isset($parts['query']) ? $parts['query'] : null;
        $fragment = isset($parts['fragment']) ? $parts['fragment'] : null;

        return new URL($scheme, $user, $password, $host, $port, $path, $query, $fragment);
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getScheme() {
        return $this->scheme;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getUser() {
        return $this->user;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getHost() {
        return $this->host;
    }

    /**
     *
     * @return int
     */
    public function getPort() {
        return $this->port;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getPath() {
        return $this->path;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getFragment() {
        return $this->fragment;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getUrlString() {
        return $this->urlString;
    }

    /**
     *
     * @param blaze\lang\String|string $scheme
     * @return URL
     */
    public function setScheme(\blaze\lang\String $scheme) {
        $this->scheme = $scheme;
        $this->buildUrl();
        return $this;
    }

    public function setUser(\blaze\lang\String $user) {
        $this->user = $user;
        $this->buildUrl();
        return $this;
    }

    public function setPassword(\blaze\lang\String $password) {
        $this->password = $password;
        $this->buildUrl();
        return $this;
    }

    public function setHost(\blaze\lang\String $host) {
        $this->host = $host;
        $this->buildUrl();
        return $this;
    }

    public function setPort(\int $port) {
        $this->port = $port;
        $this->buildUrl();
        return $this;
    }

    public function setPath(\blaze\lang\String $path) {
        $this->path = $path;
        $this->buildUrl();
        return $this;
    }

    public function setQuery(\blaze\lang\String $query) {
        $this->query = $query;
        $this->buildUrl();
        return $this;
    }

    public function setFragment(\blaze\lang\String $fragment) {
        $this->fragment = $fragmet;
        $this->buildUrl();
        return $this;
    }

    private function buildUrl() {
        if ($this->scheme === null)
            throw new \blaze\lang\IllegalArgumentException('Scheme is not given!');

        $this->handler = $this->getURLStreamHandler($this->scheme);
        $this->urlString = $this->scheme . '://';

        if ($this->user === null)
            $this->urlString .= $this->user . ':' . $this->password . '@';

        if ($this->host === null)
            throw new \blaze\lang\IllegalArgumentException('Host is not given!');

        $this->urlString .= $this->host;

        if ($this->port != 0)
            $this->urlString .= ':' . $this->port;

        if ($this->path != null)
            $this->urlString .= '/' . $this->path;

        if ($this->query != null)
            $this->urlString .= '?' . $this->query;

        if ($this->fragment != null)
            $this->urlString .= '#' . $this->fragment;

        $this->urlString = new \blaze\lang\String($this->urlString);
        $this->hashCode = -1;
    }

    public static function setURLStreamHandlerFactory(URLStreamHandlerFactory $fac) {
        if ($this->factory != null) {
            throw new \blaze\lang\Error("factory already defined");
        }
//	    SecurityManager security = System.getSecurityManager();
//	    if (security != null) {
//		security.checkSetFactory();
//	    }
        $handlers->clear();
        $this->factory = $fac;
    }

    public function toString() {
        return $this->toExternalForm();
    }

    public function toExternalForm() {
        return $this->handler->toExternalForm($this);
    }

    public function toURI() {
        return new URI(null, $this);
    }

    /**
     * @return blaze\net\URLConnection
     */
    public function openConnection(Proxy $p = null) {
        return $this->handler->openConnection($this, $p);
    }

    protected function getURLStreamHandler(\blaze\lang\String $protocol) {
        $this->handler = self::$handlers->get($protocol);

        if ($this->handler == null) {

            // Use the factory (if any)
            if (self::$factory != null) {
                $this->handler = $this->factory->createURLStreamHandler($protocol);
            }

            // Try java protocol handler
//	    if ($this->handler == null) {
//		$packagePrefixList = null;
//
//		$packagePrefixList
//		    = (String) java.security.AccessController.doPrivileged(
//                    new sun.security.action.GetPropertyAction(
//		        protocolPathProp,""));
//		if (packagePrefixList != "") {
//		    packagePrefixList += "|";
//		}
//
//		// REMIND: decide whether to allow the "null" class prefix
//		// or not.
//		packagePrefixList += "sun.net.www.protocol";
//
//		StringTokenizer packagePrefixIter =
//		    new StringTokenizer(packagePrefixList, "|");
//
//		while (handler == null &&
//		       packagePrefixIter.hasMoreTokens()) {
//
//		    String packagePrefix =
//		      packagePrefixIter.nextToken().trim();
//		    try {
//		        String clsName = packagePrefix + "." + protocol +
//			  ".Handler";
//			Class cls = null;
//			try {
//                            cls = Class.forName(clsName);
//                        } catch (ClassNotFoundException e) {
//			    ClassLoader cl = ClassLoader.getSystemClassLoader();
//			    if (cl != null) {
//			        cls = cl.loadClass(clsName);
//			    }
//			}
//			if (cls != null) {
//			    handler  =
//			      (URLStreamHandler)cls.newInstance();
//			}
//		    } catch (Exception e) {
//			// any number of exceptions can get thrown here
//		    }
//		}
//	    }
            // Insert this handler into the map
            if ($this->handler != null) {
                self::$handlers->put($protocol, $this->handler);
            }
        }

        return $this->handler;
    }

    public function compareTo(Object $obj) {
        if (($c = self::compareIgnoringCase($this->scheme, $that->scheme)) != 0)
            return $c;
        if (($this->host != null) && ($that->host != null)) {
            // Both server-based
            if (($c = self::compare($this->userInfo, $that->userInfo)) != 0)
                return $c;
            if (($c = self::compareIgnoringCase($this->host, $that->host)) != 0)
                return c;
            if (($c = $this->port - $that->port) != 0)
                return $c;
        } else {
            // If one or both authorities are registry-based then we simply
            // compare them in the usual, case-sensitive way.  If one is
            // registry-based and one is server-based then the strings are
            // guaranteed to be unequal, hence the comparison will never return
            // zero and the compareTo and equals methods will remain
            // consistent.
            if (($c = self::compare($this->authority, $that->authority)) != 0)
                return $c;
        }

        if (($c = self::compare($this->path, $that->path)) != 0)
            return $c;
        if (($c = self::compare($this->query, $that->query)) != 0)
            return $c;
        return self::compare($this->fragment, $that->fragment);
    }

    // US-ASCII only
    private static function compareIgnoringCase(String $s, String $t) {
        if ($s == $t)
            return 0;
        if ($s != null) {
            if ($t != null) {
                $sn = $s->length();
                $tn = $t->length();
                $n = $sn < $tn ? $sn : $tn;
                for ($i = 0; $i < $n; $i++) {
                    $c = self::toLower($s->charAt($i)) - self::toLower($t->charAt($i));
                    if ($c != 0)
                        return $c;
                }
                return $sn - $tn;
            }
            return +1;
        } else {
            return -1;
        }
    }

    public function equals(\blaze\lang\Reflectable $obj) {
        if (!($obj instanceof URL))
            return false;

        return $this->handler->equals($this, $obj);
    }

    public function hashCode() {
        if ($this->hashCode != -1)
            return $this->hashCode;

        $this->hashCode = $this->handler->hashCode($this);
        return $this->hashCode;
    }

}

?>
