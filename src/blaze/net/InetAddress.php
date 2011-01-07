<?php

namespace blaze\net;

use blaze\lang\Object;

/**
 * Description of URI
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class InetAddress extends Object implements \blaze\io\Serializable {

    /**
     * Specify the address family: Internet Protocol, Version 4
     * @since 1.4
     */
    protected static $IPv4 = 1;
    /**
     * Specify the address family: Internet Protocol, Version 6
     * @since 1.4
     */
    protected static $IPv6 = 2;

    /* Specify address family preference */
    protected static $preferIPv6Address = false;
    /**
     * @var blaze\lang\String
     */
    private $hostName;
    /**
     * Holds a 32-bit IPv4 address.
     *
     * @var int
     */
    private $address;
    /**
     * Specifies the address family type, for instance, '1' for IPv4
     * addresses, and '2' for IPv6 addresses.
     *
     * @serial
     */
    private $family;
    /**
     *  Used to store the name service provider
     * @var blaze\net\NameService
     */
    private static $nameService = null;
    /**
     *  Used to store the best available hostname
     * @var blaze\lang\String
     */
    private $canonicalHostName = null;

    /**
     * Utility routine to check if the InetAddress is an
     * IP multicast address.
     * @return a <code>boolean</code> indicating if the InetAddress is
     * an IP multicast address
     * @since   JDK1.1
     */
    public function isMulticastAddress() {
        return false;
    }

    /**
     * Utility routine to check if the InetAddress in a wildcard address.
     * @return a <code>boolean</code> indicating if the Inetaddress is
     *         a wildcard address.
     * @since 1.4
     */
    public function isAnyLocalAddress() {
        return false;
    }

    /**
     * Utility routine to check if the InetAddress is a loopback address.
     *
     * @return a <code>boolean</code> indicating if the InetAddress is
     * a loopback address; or false otherwise.
     * @since 1.4
     */
    public function isLoopbackAddress() {
        return false;
    }

    /**
     * Utility routine to check if the InetAddress is an link local address.
     *
     * @return a <code>boolean</code> indicating if the InetAddress is
     * a link local address; or false if address is not a link local unicast address.
     * @since 1.4
     */
    public function isLinkLocalAddress() {
        return false;
    }

    /**
     * Utility routine to check if the InetAddress is a site local address.
     *
     * @return a <code>boolean</code> indicating if the InetAddress is
     * a site local address; or false if address is not a site local unicast address.
     * @since 1.4
     */
    public function isSiteLocalAddress() {
        return false;
    }

    /**
     * Utility routine to check if the multicast address has global scope.
     *
     * @return a <code>boolean</code> indicating if the address has
     *         is a multicast address of global scope, false if it is not
     *         of global scope or it is not a multicast address
     * @since 1.4
     */
    public function isMCGlobal() {
        return false;
    }

    /**
     * Utility routine to check if the multicast address has node scope.
     *
     * @return a <code>boolean</code> indicating if the address has
     *         is a multicast address of node-local scope, false if it is not
     *         of node-local scope or it is not a multicast address
     * @since 1.4
     */
    public function isMCNodeLocal() {
        return false;
    }

    /**
     * Utility routine to check if the multicast address has link scope.
     *
     * @return a <code>boolean</code> indicating if the address has
     *         is a multicast address of link-local scope, false if it is not
     *         of link-local scope or it is not a multicast address
     * @since 1.4
     */
    public function isMCLinkLocal() {
        return false;
    }

    /**
     * Utility routine to check if the multicast address has site scope.
     *
     * @return a <code>boolean</code> indicating if the address has
     *         is a multicast address of site-local scope, false if it is not
     *         of site-local scope or it is not a multicast address
     * @since 1.4
     */
    public function isMCSiteLocal() {
        return false;
    }

    /**
     * Utility routine to check if the multicast address has organization scope.
     *
     * @return a <code>boolean</code> indicating if the address has
     *         is a multicast address of organization-local scope,
     *         false if it is not of organization-local scope
     *         or it is not a multicast address
     * @since 1.4
     */
    public function isMCOrgLocal() {
        return false;
    }

    /**
     * Test whether that address is reachable. Best effort is made by the
     * implementation to try to reach the host, but firewalls and server
     * configuration may block requests resulting in a unreachable status
     * while some specific ports may be accessible.
     * A typical implementation will use ICMP ECHO REQUESTs if the
     * privilege can be obtained, otherwise it will try to establish
     * a TCP connection on port 7 (Echo) of the destination host.
     * <p>
     * The <code>network interface</code> and <code>ttl</code> parameters
     * let the caller specify which network interface the test will go through
     * and the maximum number of hops the packets should go through.
     * A negative value for the <code>ttl</code> will result in an
     * IllegalArgumentException being thrown.
     * <p>
     * The timeout value, in milliseconds, indicates the maximum amount of time
     * the try should take. If the operation times out before getting an
     * answer, the host is deemed unreachable. A negative value will result
     * in an IllegalArgumentException being thrown.
     *
     * @param	netif   the NetworkInterface through which the
     * 			  test will be done, or null for any interface
     * @param	ttl	the maximum numbers of hops to try or 0 for the
     * 			default
     * @param	timeout	the time, in milliseconds, before the call aborts
     * @throws  IllegalArgumentException if either <code>timeout</code>
     * 				or <code>ttl</code> are negative.
     * @return blaze\lang\String a <code>boolean</code>indicating if the address is reachable.
     * @throws IOException if a network error occurs
     * @since 1.5
     */
    public function isReachable($timeout, NetworkInterface $netif = null, $ttl = 0) {
        if ($ttl < 0)
            throw new IllegalArgumentException('ttl can\'t be negative');
        if ($timeout < 0)
            throw new IllegalArgumentException('timeout can\'t be negative');

        return $this->impl->isReachable($this, $timeout, $netif, $ttl);
    }

    /**
     * Returns the hostname for this address.
     * If the host is equal to null, then this address refers to any
     * of the local machine's available network addresses.
     * this is package private so SocketPermission can make calls into
     * here without a security check.
     *
     * <p>If there is a security manager, this method first
     * calls its <code>checkConnect</code> method
     * with the hostname and <code>-1</code>
     * as its arguments to see if the calling code is allowed to know
     * the hostname for this IP address, i.e., to connect to the host.
     * If the operation is not allowed, it will return
     * the textual representation of the IP address.
     *
     * @return  the host name for this IP address, or if the operation
     *    is not allowed by the security check, the textual
     *    representation of the IP address.
     *
     * @param check make security check if true
     *
     * @see SecurityManager#checkConnect
     */
    public function getHostName($check = true) {
        if ($this->hostName == null) {
            $this->hostName = InetAddress::getHostFromNameService($this, $check);
        }
        return $this->hostName;
    }

    /**
     * Gets the fully qualified domain name for this IP address.
     * Best effort method, meaning we may not be able to return
     * the FQDN depending on the underlying system configuration.
     *
     * <p>If there is a security manager, this method first
     * calls its <code>checkConnect</code> method
     * with the hostname and <code>-1</code>
     * as its arguments to see if the calling code is allowed to know
     * the hostname for this IP address, i.e., to connect to the host.
     * If the operation is not allowed, it will return
     * the textual representation of the IP address.
     *
     * @return blaze\lang\String the fully qualified domain name for this IP address,
     *    or if the operation is not allowed by the security check,
     *    the textual representation of the IP address.
     *
     * @see SecurityManager#checkConnect
     *
     * @since 1.4
     */
    public function getCanonicalHostName() {
        if ($this->canonicalHostName == null) {
            $this->canonicalHostName =
                    InetAddress::getHostFromNameService($this, true);
        }
        return $this->canonicalHostName;
    }

    /**
     * Returns the hostname for this address.
     *
     * <p>If there is a security manager, this method first
     * calls its <code>checkConnect</code> method
     * with the hostname and <code>-1</code>
     * as its arguments to see if the calling code is allowed to know
     * the hostname for this IP address, i.e., to connect to the host.
     * If the operation is not allowed, it will return
     * the textual representation of the IP address.
     *
     * @return  the host name for this IP address, or if the operation
     *    is not allowed by the security check, the textual
     *    representation of the IP address.
     *
     * @param check make security check if true
     *
     * @see SecurityManager#checkConnect
     */
    private static function getHostFromNameService(InetAddress $addr, $check) {
        $host = null;

        try {
            // first lookup the hostname
            $host = $this->nameService->getHostByAddr($addr->getAddress());

//	    /* check to see if calling code is allowed to know
//	     * the hostname for this IP address, ie, connect to the host
//	     */
//	    if ($check) {
//		$sec = System::getSecurityManager();
//		if ($sec != null) {
//		    $sec->checkConnect($host, -1);
//		}
//	    }

            /* now get all the IP addresses for this hostname,
             * and make sure one of them matches the original IP
             * address. We do this to try and prevent spoofing.
             */

            $arr = InetAddress::getAllByName0($host, $check);
            $ok = false;

            if ($arr != null) {
                for ($i = 0; !$ok && $i < $arr->length; $i++) {
                    $ok = $addr->equals($arr[$i]);
                }
            }

            //XXX: if it looks a spoof just return the address?
            if (!$ok) {
                $host = $addr->getHostAddress();
                return $host;
            }
        } catch (SecurityException $e) {
            $host = $addr->getHostAddress();
        } catch (UnknownHostException $e) {
            $host = $addr->getHostAddress();
        }
        return $host;
    }

    /**
     * Returns the raw IP address of this <code>InetAddress</code>
     * object. The result is in network byte order: the highest order
     * byte of the address is in <code>getAddress()[0]</code>.
     *
     * @return  the raw IP address of this object.
     */
    public function getAddress() {
        return null;
    }

    /**
     * Returns the IP address string in textual presentation.
     *
     * @return blaze\lang\String the raw IP address in a string format.
     * @since   JDK1.0.2
     */
    public function getHostAddress() {
        return null;
    }

    /**
     * Returns a hashcode for this IP address.
     *
     * @return int a hash code value for this IP address.
     */
    public function hashCode() {
        return -1;
    }

    /**
     * Compares this object against the specified object.
     * The result is <code>true</code> if and only if the argument is
     * not <code>null</code> and it represents the same IP address as
     * this object.
     * <p>
     * Two instances of <code>InetAddress</code> represent the same IP
     * address if the length of the byte arrays returned by
     * <code>getAddress</code> is the same for both, and each of the
     * array components is the same for the byte arrays.
     *
     * @param   obj   the object to compare against.
     * @return boolean <code>true</code> if the objects are the same;
     *          <code>false</code> otherwise.
     * @see     java.net.InetAddress#getAddress()
     */
    public function equals(\blaze\lang\Reflectable $obj) {
        return false;
    }

    /**
     * Converts this IP address to a <code>String</code>. The
     * string returned is of the form: hostname / literal IP
     * address.
     *
     * If the host name is unresolved, no reverse name service loopup
     * is performed. The hostname part will be represented by an empty string.
     *
     * @return  a string representation of this IP address.
     */
    public function toString() {
        return (($this->hostName != null) ? $this->hostName : '')
        . '/' . $this->getHostAddress();
    }

    protected final function expandIPv6Notation(\blaze\lang\String $ip) {
        if ($ip->indexOf('::') !== -1)
            $ip = $ip->replace('::', str_repeat(':0', 8 - substr_count($ip, ':')) . ':');
        if ($ip->indexOf(':') === 0)
            $ip = '0' . $ip;
        return \blaze\lang\String::asWrapper($ip);
    }

    protected final function textToNumericFormatV4(\blaze\lang\String $string) {
        $ret = ip2long($string);
        return $ret === false ? null : $ret;
    }

    protected final function textToNumericFormatV6(\blaze\lang\String $ip) {
        $ip = ExpandIPv6Notation($ip);
        $parts = explode(':', $ip);
        $ip = array('', '');

        for ($i = 0; $i < 4; $i++)
            $ip[0] .= str_pad(base_convert($parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);
        for ($i = 4; $i < 8; $i++)
            $ip[1] .= str_pad(base_convert($parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);

        return base_convert($ip[0], 2, 10) + base_convert($ip[1], 2, 10);
    }

    protected final function convertIPv4To6(\blaze\lang\String $ip) {
        $IPv6 = self::isIPv6LiteralAddress($ip);
        $IPv4 = self::isIPv4LiteralAddress($ip);

        if (!$IPv4 && !$IPv6)
            return null;
        if ($IPv6 && $IPv4)
            $ip = $ip->substring($ip->indexOf(':') + 1); // Strip IPv4 Compatibility notation
 elseif (!$IPv4)
            return $ip; // Seems to be IPv6 already?

        $ipParts = $ip->split('.');

        $part7 = base_convert(($ipParts[0] * 256) + $ipParts[1], 10, 16);
        $part8 = base_convert(($ipParts[2] * 256) + $ipParts[3], 10, 16);
        $mask = '::ffff:'; // This tells IPv6 it has an IPv4 address

        return \blaze\lang\String::asWrapper($mask . $part7 . ':' . $part8);
    }

    protected final function convertIPv6To4(\blaze\lang\String $ip) {
        $mask = '::ffff:';
        $IPv6 = self::isIPv6LiteralAddress($ip);
        $IPv4 = self::isIPv4LiteralAddress($ip);

        if (!$IPv4 && !$IPv6)
            return null;
        if (!$IPv6)
            return $ip; // Seems to be IPv4 already?
        if (!$ip->startsWith($mask))
            return null;

        $ipParts = $ip->substring(strlen($mask))->split(':');
        $part7 = base_convert($ipParts[0], 16, 10);
        $part8 = base_convert($ipParts[1], 16, 10);
        $part7 = base_convert(($ipParts[0] * 256) + $ipParts[1], 10, 16);
        $part8 = base_convert(($ipParts[2] * 256) + $ipParts[3], 10, 16);
        $ip4[0] = $part7 >> 8;
        $ip4[1] = $part7 & 0xF;
        $ip4[2] = $part8 >> 8;
        $ip4[3] = $part8 & 0xF;

        return \blaze\lang\String::asWrapper(implode('.', $ip4));
    }

    protected final function isIPv4LiteralAddress(\blaze\lang\String $string) {
        return $string->matches('/((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])\\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])/');
    }

    protected final function isIPv6LiteralAddress(\blaze\lang\String $string) {
        return $string->matches('/(?:(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-fA-F]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:(?:[0-9a-fA-F]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,1}(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:(?:[0-9a-fA-F]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,2}(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:(?:[0-9a-fA-F]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,3}(?:(?:[0-9a-fA-F]{1,4})))?::(?:(?:[0-9a-fA-F]{1,4})):)(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,4}(?:(?:[0-9a-fA-F]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,5}(?:(?:[0-9a-fA-F]{1,4})))?::)(?:(?:[0-9a-fA-F]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-fA-F]{1,4})):){0,6}(?:(?:[0-9a-fA-F]{1,4})))?::))))/');
    }

    /*
     * Cached addresses - our own litle nis, not!
     */

//    private static Cache addressCache = new Cache(Cache.Type.Positive);
//
//    private static Cache negativeCache = new Cache(Cache.Type.Negative);
//
//    private static boolean addressCacheInit = false;
//
//    static InetAddress[]    unknown_array; // put THIS in cache
//
//    static InetAddressImpl  impl;
//
//    private static HashMap          lookupTable = new HashMap();




    /*
     * Initialize cache and insert anyLocalAddress into the
     * unknown array with no expiry.
     */
//    private static void cacheInitIfNeeded() {
//        assert Thread.holdsLock(addressCache);
//        if (addressCacheInit) {
//            return;
//        }
//        unknown_array = new InetAddress[1];
//        unknown_array[0] = impl.anyLocalAddress();
//
//	addressCache.put(impl.anyLocalAddress().getHostName(),
//	                 unknown_array);
//
//        addressCacheInit = true;
//    }

    /*
     * Cache the given hostname and address.
     */
    private static function cacheAddress(\blaze\lang\String $hostname, \blaze\lang\Object $address, $success) {
        $hostname = $hostname->toLowerCase();
//	    cacheInitIfNeeded();
        if ($success) {
            $this->addressCache->put($hostname, $address);
        } else {
            $this->negativeCache->put($hostname, $address);
        }
    }

    /*
     * Lookup hostname in cache (positive & negative cache). If
     * found return address, null if not found.
     */

    private static function getCachedAddress(\blaze\lang\String $hostname) {
        $hostname = $hostname->toLowerCase();

        // search both positive & negative caches
        $entry = null;

//	    cacheInitIfNeeded();

        $entry = $this->addressCache->get($hostname);
        if ($entry == null) {
            $entry = $this->negativeCache->get($hostname);
        }

        if ($entry != null) {
            return $entry->address;
        }


        // not found
        return null;
    }

//    static {
//  	// create the impl
//	impl = (new InetAddressImplFactory()).create();
//
//	// get name service if provided and requested
//	String provider = null;;
//	String propPrefix = 'sun.net.spi.nameservice.provider.';
//	int n = 1;
//	    while (nameService == null) {
//		provider
//		    = (String)AccessController.doPrivileged(
//			new GetPropertyAction(propPrefix+n, 'default'));
//		n++;
//		if (provider.equals('default')) {
//		    // initialize the default name service
//		    nameService = new NameService() {
//			public InetAddress[] lookupAllHostAddr(String host)
//			    throws UnknownHostException {
//			    return impl.lookupAllHostAddr(host);
//			}
//			public String getHostByAddr(byte[] addr)
//			    throws UnknownHostException {
//			    return impl.getHostByAddr(addr);
//			}
//		    };
//		    break;
//		}
//
//		final String providerName = provider;
//
//		try {
//		    java.security.AccessController.doPrivileged(
//			new java.security.PrivilegedExceptionAction() {
//			    public Object run() {
//				Iterator itr
//		    		    = Service.providers(NameServiceDescriptor.class);
//				while (itr.hasNext()) {
//		    		    NameServiceDescriptor nsd
//					= (NameServiceDescriptor)itr.next();
//		    		    if (providerName.
//				        equalsIgnoreCase(nsd.getType()+','
//			       		    +nsd.getProviderName())) {
//					try {
//			    	    	    nameService = nsd.createNameService();
//			    	    	    break;
//					} catch (Exception e) {
//					    e.printStackTrace();
//			    	    	    System.err.println(
//						'Cannot create name service:'
//					         +providerName+': ' + e);
//					}
//		    		    }
//				} /* while */
//			        return null;
//			}
//		    });
//		} catch (java.security.PrivilegedActionException e) {
//		}
//
//	    }
//    }

    /**
     * Create an InetAddress based on the provided host name and IP address
     * No name service is checked for the validity of the address.
     *
     * <p> The host name can either be a machine name, such as
     * '<code>java.sun.com</code>', or a textual representation of its IP
     * address.
     * <p> No validity checking is done on the host name either.
     *
     * <p> If addr specifies an IPv4 address an instance of Inet4Address
     * will be returned; otherwise, an instance of Inet6Address
     * will be returned.
     *
     * <p> IPv4 address byte array must be 4 bytes long and IPv6 byte array
     * must be 16 bytes long
     *
     * @param host the specified host
     * @param addr the raw IP address in network byte order
     * @return InetAddress an InetAddress object created from the raw IP address.
     * @exception  UnknownHostException  if IP address is of illegal length
     * @since 1.4
     */
    public static function getByAddress(\blaze\lang\String $host, $addr) {
        if ($host != null && $host->length() > 0 && $host->charAt(0) == '[') {
            if ($host->charAt($host->length() - 1) == ']') {
                $host = $host->substring(1, $host->length() - 1);
            }
        }
        if ($addr != null) {
            if ($addr->length == Inet4Address::INADDRSZ) {
                return new Inet4Address($host, $addr);
            } else if ($addr->length == Inet6Address::INADDRSZ) {
                $newAddr = IPAddressUtil::convertFromIPv4MappedAddress($addr);
                if ($newAddr != null) {
                    return new Inet4Address($host, $newAddr);
                } else {
                    return new Inet6Address($host, $addr);
                }
            }
        }
//	throw new UnknownHostException('addr is of illegal length');
    }

    /**
     * Determines the IP address of a host, given the host's name.
     *
     * <p> The host name can either be a machine name, such as
     * '<code>java.sun.com</code>', or a textual representation of its
     * IP address. If a literal IP address is supplied, only the
     * validity of the address format is checked.
     *
     * <p> For <code>host</code> specified in literal IPv6 address,
     * either the form defined in RFC 2732 or the literal IPv6 address
     * format defined in RFC 2373 is accepted. IPv6 scoped addresses are also
     * supported. See <a href='Inet6Address.html#scoped'>here</a> for a description of IPv6
     * scoped addresses.
     *
     * <p> If the host is <tt>null</tt> then an <tt>InetAddress</tt>
     * representing an address of the loopback interface is returned.
     * See <a href='http://www.ietf.org/rfc/rfc3330.txt'>RFC&nbsp;3330</a>
     * section&nbsp;2 and <a href='http://www.ietf.org/rfc/rfc2373.txt'>RFC&nbsp;2373</a>
     * section&nbsp;2.5.3. </p>
     *
     * @param      host   the specified host, or <code>null</code>.
     * @return InetAddress    an IP address for the given host name.
     * @exception  UnknownHostException  if no IP address for the
     *               <code>host</code> could be found, or if a scope_id was specified
     * 		     for a global IPv6 address.
     * @exception  SecurityException if a security manager exists
     *             and its checkConnect method doesn't allow the operation
     */
    public static function getByName(\blaze\lang\String $host, InetAddress $reqAddr = null) {
        $addr = InetAddress::getAllByName($host, $reqAddr);
        return $addr[0];
    }

    /**
     * Given the name of a host, returns an array of its IP addresses,
     * based on the configured name service on the system.
     *
     * <p> The host name can either be a machine name, such as
     * '<code>java.sun.com</code>', or a textual representation of its IP
     * address. If a literal IP address is supplied, only the
     * validity of the address format is checked.
     *
     * <p> For <code>host</code> specified in <i>literal IPv6 address</i>,
     * either the form defined in RFC 2732 or the literal IPv6 address
     * format defined in RFC 2373 is accepted. A literal IPv6 address may
     * also be qualified by appending a scoped zone identifier or scope_id.
     * The syntax and usage of scope_ids is described
     * <a href='Inet6Address.html#scoped'>here</a>.
     * <p> If the host is <tt>null</tt> then an <tt>InetAddress</tt>
     * representing an address of the loopback interface is returned.
     * See <a href='http://www.ietf.org/rfc/rfc3330.txt'>RFC&nbsp;3330</a>
     * section&nbsp;2 and <a href='http://www.ietf.org/rfc/rfc2373.txt'>RFC&nbsp;2373</a>
     * section&nbsp;2.5.3. </p>
     *
     * <p> If there is a security manager and <code>host</code> is not
     * null and <code>host.length() </code> is not equal to zero, the
     * security manager's
     * <code>checkConnect</code> method is called
     * with the hostname and <code>-1</code>
     * as its arguments to see if the operation is allowed.
     *
     * @param      host   the name of the host, or <code>null</code>.
     * @return  array[InetAddress]   an array of all the IP addresses for a given host name.
     *
     * @exception  UnknownHostException  if no IP address for the
     *               <code>host</code> could be found, or if a scope_id was specified
     * 		     for a global IPv6 address.
     * @exception  SecurityException  if a security manager exists and its
     *               <code>checkConnect</code> method doesn't allow the operation.
     *
     * @see SecurityManager#checkConnect
     */
    public static function getAllByName($host, InetAddress $reqAddr = null) {
        $host = \blaze\lang\String::asWrapper($host);
        if ($host->length() == 0) {
            $ret = new \blaze\collections\arrays\ArrayObject(1);
            $ret[0] = $impl->loopbackAddress();
            return $ret;
        }

        $ipv6Expected = false;
        if ($host->charAt(0) == '[') {
            // This is supposed to be an IPv6 litteral
            if ($host->length() > 2 && $host->charAt($host->length() - 1) == ']') {
                $host = $host->substring(1, $host->length() - 1);
                $ipv6Expected = true;
            } else {
                // This was supposed to be a IPv6 address, but it's not!
//		throw new UnknownHostException(4host);
            }
        }

        // if host is an IP address, we won't do further lookup
        if (\blaze\lang\Character::digit($host->charAt(0), 16) != -1
                || ($host->charAt(0) == ':')) {
            $addr = null;
            $numericZone = -1;
            $ifname = null;
            // see if it is IPv4 address
            $addr = self::textToNumericFormatV4($host);
            if ($addr == null) {
                // see if it is IPv6 address
                // Check if a numeric or string zone id is present
                if (($pos = $host->indexOf('%')) != -1) {
                    $numericZone = $self::checkNumericZone($host);
                    if ($numericZone == -1) { /* remainder of string must be an ifname */
                        $ifname = $host->substring($pos + 1);
                    }
                }
                $addr = IPAddressUtil::textToNumericFormatV6($host);
            } else if ($ipv6Expected) {
                // Means an IPv4 litteral between brackets!
//		throw new UnknownHostException('['+host+']');
            }
            $ret = new ArrayObject(1);
            if ($addr != null) {
                if ($addr->length == Inet4Address::INADDRSZ) {
                    $ret[0] = new Inet4Address(null, $addr);
                } else {
                    if ($ifname != null) {
                        $ret[0] = new Inet6Address(null, $addr, $ifname);
                    } else {
                        $ret[0] = new Inet6Address(null, $addr, $numericZone);
                    }
                }
                return $ret;
            }
        } else if ($ipv6Expected) {
            // We were expecting an IPv6 Litteral, but got something else
//		throw new UnknownHostException('['+host+']');
        }
        return self::getAllByName0($host, $reqAddr, true);
    }

    /**
     * check if the literal address string has %nn appended
     * returns -1 if not, or the numeric value otherwise.
     *
     * %nn may also be a string that represents the displayName of
     * a currently available NetworkInterface.
     * @return int
     */
    private static function checkNumericZone(\blaze\lang\String $s) {
        $percent = $s->indexOf('%');
        $slen = $s->length();
        $digit = null;
        $zone = 0;

        if ($percent == -1) {
            return -1;
        }
        for ($i = $percent + 1; $i < $slen; $i++) {
            $c = $s->charAt($i);
            if ($c == ']') {
                if ($i == $percent + 1) {
                    /* empty per-cent field */
                    return -1;
                }
                break;
            }
            if (($digit = \baze\lang\Character::digit($c, 10)) < 0) {
                return -1;
            }
            $zone = ($zone * 10) + $digit;
        }
        return $zone;
    }

    private static function getAllByName0(\blaze\lang\String $host, InetAddress $reqAddr, $check = true) {

        /* If it gets here it is presumed to be a hostname */
        /* Cache.get can return: null, unknownAddress, or InetAddress[] */
        $obj = null;
        $objcopy = null;

        /* make sure the connection to the host is allowed, before we
         * give out a hostname
         */
//        if ($check) {
//            $security = System::getSecurityManager();
//            if ($security != null) {
//                $security->checkConnect($host, -1);
//            }
//        }

        $obj = self::getCachedAddress($host);

        /* If no entry in cache, then do the host lookup */
        if ($obj == null) {
            $obj = self::getAddressFromNameService($host, $reqAddr);
        }

//	if ($obj == $unknown_array)
//	    throw new UnknownHostException($host);

        /* Make a copy of the InetAddress array */
        $objcopy = $obj->cloneObject();

        return $objcopy;
    }

    private static function getAddressFromNameService(\blaze\lang\String $host, InetAddress $reqAddr) {
        $obj = null;
        $success = false;
        $isLocalHost = false;
        $exc = null;

        // Check whether the host is in the lookupTable.
        // 1) If the host isn't in the lookupTable when
        //    checkLookupTable() is called, checkLookupTable()
        //    would add the host in the lookupTable and
        //    return null. So we will do the lookup.
        // 2) If the host is in the lookupTable when
        //    checkLookupTable() is called, the current thread
        //    would be blocked until the host is removed
        //    from the lookupTable. Then this thread
        //    should try to look up the addressCache.
        //     i) if it found the address in the
        //        addressCache, checkLookupTable()  would
        //        return the address.
        //     ii) if it didn't find the address in the
        //         addressCache for any reason,
        //         it should add the host in the
        //         lookupTable and return null so the
        //         following code would do  a lookup itself.
        if (($obj = self::checkLookupTable($host)) == null) {
            // This is the first thread which looks up the address
            // this host or the cache entry for this host has been
            // expired so this thread should do the lookup.
            try {
                /*
                 * Do not put the call to lookup() inside the
                 * constructor.  if you do you will still be
                 * allocating space when the lookup fails.
                 */

                $obj = $nameService->lookupAllHostAddr($host);
                $success = true;
            } catch (UnknownHostException $uhe) {
                $isLocalHost = $host->equalsIgnoreCase('localhost');
                $exc = $uhe;

                if ($isLocalHost) {
                    $local = new ArrayObject(1);
                    $local[0] = $impl->loopbackAddress();
                    $obj = $local;
                    $success = true;
                }
            }
            // More to do?
            $addrs = $obj;
            if ($reqAddr != null && $addrs->length > 1 && !$addrs[0]->equals($reqAddr)) {
                // Find it?
                $i = 1;
                for (; $i < $addrs->length; $i++) {
                    if ($addrs[$i]->equals($reqAddr)) {
                        break;
                    }
                }
                // Rotate
                if ($i < $addrs->length) {
                    $tmp2 = $reqAddr;
                    for ($j = 0; $j < $i; $j++) {
                        $tmp = $addrs[$j];
                        $addrs[$j] = $tmp2;
                        $tmp2 = $tmp;
                    }
                    $addrs[$i] = $tmp2;
                }
            }
            // Cache the address.
            self::cacheAddress($host, $obj, $success);
            // Delete the host from the lookupTable, and
            // notify all threads waiting for the monitor
            // for lookupTable.
            self::updateLookupTable($host);
        }


        if (!$isLocalHost && $exc != null) {
            $obj = $unknown_array;
            $success = false;
            throw $exc;
        }

        return $obj;
    }

    private static function checkLookupTable(\blaze\lang\String $host) {
        // make sure obj  is null.
        $obj = null;

        // If the host isn't in the lookupTable, add it in the
        // lookuptable and return null. The caller should do
        // the lookup.
        if ($lookupTable->containsKey($host) == false) {
            $lookupTable->put($host, null);
            return obj;
        }


        // The other thread has finished looking up the address of
        // the host. This thread should retry to get the address
        // from the addressCache. If it doesn't get the address from
        // the cache,  it will try to look up the address itself.
        $obj = self::getCachedAddress($host);
        if ($obj == null) {
            $lookupTable->put($host, null);
        }

        return $obj;
    }

    private static function updateLookupTable(\blaze\lang\String $host) {
        $lookupTable->remove($host);
    }

    /**
     * Returns the local host.
     *
     * <p>If there is a security manager, its
     * <code>checkConnect</code> method is called
     * with the local host name and <code>-1</code>
     * as its arguments to see if the operation is allowed.
     * If the operation is not allowed, an InetAddress representing
     * the loopback address is returned.
     *
     * @return InetAddress    the IP address of the local host.
     *
     * @exception  UnknownHostException  if no IP address for the
     *               <code>host</code> could be found.
     *
     * @see SecurityManager#checkConnect
     */
    public static function getLocalHost() {

        $security = System::getSecurityManager();
        try {
            $local = $impl->getLocalHostName();

//	    if (security != null) {
//		security.checkConnect(local, -1);
//	    }

            if ($local->equals('localhost')) {
                return $impl->loopbackAddress();
            }

            // we are calling getAddressFromNameService directly
            // to avoid getting localHost from cache

            $localAddrs = null;
            try {
                $localAddrs = InetAddress::getAddressFromNameService($local, null);
            } catch (UnknownHostException $uhe) {
                throw new UnknownHostException($local + ': ' + $uhe->getMessage());
            }
            return $localAddrs[0];
        } catch (\blaze\lang\SecurityException $e) {
            return $impl->loopbackAddress();
        }
    }

    /*
     * Returns the InetAddress representing anyLocalAddress
     * (typically 0.0.0.0 or ::0)
     * @return InetAddress
     */

    protected static function anyLocalAddress() {
        return $this->impl->anyLocalAddress();
    }

}

/**
 * Represents a cache entry
 * @access private
 */
final class CacheEntry {

    /**
     * @var blaze\lang\Object
     */
    public $address;
    /**
     * @var long
     */
    public $expiration;

    public function __construct(\blaze\lang\Object $address, $expiration) {
        $this->address = $address;
        $this->expiration = $expiration;
    }

}

/**
 * A cache that manages entries based on a policy specified
 * at creation time.
 */
final class Cache {

    /**
     * @var blaze\collections\map\LinkedHashMap
     */
    private $cache;
    /**
     * Wether positive - true or negative - false
     * @var int
     */
    private $type;

    /**
     * Create cache
     */
    public function __construct($positiveType) {
        $this->type = $positiveType;
        $this->cache = new \blaze\collections\map\LinkedHashMap();
    }

    private function getPolicy() {
        if ($this->type) {
            return InetAddressCachePolicy::get();
        } else {
            return InetAddressCachePolicy::getNegative();
        }
    }

    /**
     * Add an entry to the cache. If there's already an
     * entry then for this host then the entry will be
     * replaced.
     */
    public function put(\blaze\lang\String $host, \blaze\lang\Object $address) {
        $policy = $this->getPolicy();
        if ($policy == InetAddressCachePolicy::NEVER) {
            return $this;
        }

        // purge any expired entries

        if ($policy != InetAddressCachePolicy::FOREVER) {

            // As we iterate in insertion order we can
            // terminate when a non-expired entry is found.
            $expired = new LinkedList();
            $i = $cache->keySet()->iterator();
            $now = System::currentTimeMillis();
            while ($i->hasNext()) {
                $key = $i->next();
                $entry = $cache->get($key);

                if ($entry->expiration >= 0 && $entry->expiration < $now) {
                    $expired->add($key);
                } else {
                    break;
                }
            }

            $i = $expired->iterator();
            while ($i->hasNext()) {
                $cache->remove($i->next());
            }
        }

        // create new entry and add it to the cache
        // -- as a HashMap replaces existing entries we
        //    don't need to explicitly check if there is
        //    already an entry for this host.
        $expiration;
        if ($policy == InetAddressCachePolicy::FOREVER) {
            $expiration = -1;
        } else {
            $expiration = System::currentTimeMillis() + ($policy * 1000);
        }
        $entry = new CacheEntry($address, $expiration);
        $cache->put($host, $entry);
        return $this;
    }

    /**
     * Query the cache for the specific host. If found then
     * return its CacheEntry, or null if not found.
     */
    public function get(\blaze\lang\String $host) {
        $policy = $this->getPolicy();
        if ($policy == InetAddressCachePolicy::NEVER) {
            return null;
        }
        $entry = $cache->get($host);

        // check if entry has expired
        if ($entry != null && $policy != InetAddressCachePolicy::FOREVER) {
            if ($entry->expiration >= 0 &&
                    $entry->expiration < System::currentTimeMillis()) {
                $cache->remove($host);
                $entry = null;
            }
        }

        return $entry;
    }

}

/*
 * Simple factory to create the impl
 */

class InetAddressImplFactory {

    /**
     * @return InetAddressImpl
     */
    public static function create() {
        $o = null;
        if (self::isIPv6Supported()) {
            $o = InetAddress::loadImpl('Inet6AddressImpl');
        } else {
            $o = InetAddress::loadImpl('Inet4AddressImpl');
        }
        return $o;
    }

    public static function isIPv6Supported() {
        return true;
    }

}

?>
