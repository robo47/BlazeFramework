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
final class Inet4Address extends InetAddress {
    const INADDRSZ = 4;

    public function Inet4Address(\blaze\lang\String $hostName, $address) {
        $this->hostName = $hostName;
        $this->family = self::$IPv4;
        $this->address = $address;
    }

    /**
     * Replaces the object to be serialized with an InetAddress object.
     *
     * @return the alternate object to be serialized.
     *
     * @throws ObjectStreamException if a new object replacing this
     * object could not be created
     */
//    private Object writeReplace() throws ObjectStreamException {
//	// will replace the to be serialized 'this' object
//	InetAddress inet = new InetAddress();
//	inet.hostName = this.hostName;
//	inet.address = this.address;
//
//	/**
//	 * Prior to 1.4 an InetAddress was created with a family
//  	 * based on the platform AF_INET value (usually 2).
//         * For compatibility reasons we must therefore write the
//	 * the InetAddress with this family.
//	 */
//	inet.family = 2;
//
//	return inet;
//    }

    /**
     * Utility routine to check if the InetAddress is an
     * IP multicast address. IP multicast address is a Class D
     * address i.e first four bits of the address are 1110.
     * @return a <code>boolean</code> indicating if the InetAddress is
     * an IP multicast address
     * @since   JDK1.1
     */
    public function isMulticastAddress() {
        return (($this->address & 0xf0000000) == 0xe0000000);
    }

    /**
     * Utility routine to check if the InetAddress in a wildcard address.
     * @return a <code>boolean</code> indicating if the Inetaddress is
     *         a wildcard address.
     * @since 1.4
     */
    public function isAnyLocalAddress() {
        return $this->address == 0;
    }

    /**
     * Utility routine to check if the InetAddress is a loopback address.
     *
     * @return a <code>boolean</code> indicating if the InetAddress is
     * a loopback address; or false otherwise.
     * @since 1.4
     */
    private static $loopback = 2130706433; /* 127.0.0.1 */

    public function isLoopbackAddress() {
        /* 127.x.x.x */
        $byteAddr = $this->getAddress();
        return $byteAddr[0] == 127;
    }

    /**
     * Utility routine to check if the InetAddress is an link local address.
     *
     * @return a <code>boolean</code> indicating if the InetAddress is
     * a link local address; or false if address is not a link local unicast address.
     * @since 1.4
     */
    public function isLinkLocalAddress() {
        // link-local unicast in IPv4 (169.254.0.0/16)
        // defined in "Documenting Special Use IPv4 Address Blocks
        // that have been Registered with IANA" by Bill Manning
        // draft-manning-dsua-06.txt
        return ((($this->address >> 24) & 0xFF) == 169)
        && ((($this->address >> 16) & 0xFF) == 254);
    }

    /**
     * Utility routine to check if the InetAddress is a site local address.
     *
     * @return a <code>boolean</code> indicating if the InetAddress is
     * a site local address; or false if address is not a site local unicast address.
     * @since 1.4
     */
    public function isSiteLocalAddress() {
        // refer to RFC 1918
        // 10/8 prefix
        // 172.16/12 prefix
        // 192.168/16 prefix
        return ((($this->address >> 24) & 0xFF) == 10)
        || (((($this->address >> 24) & 0xFF) == 172)
        && ((($this->address >> 16) & 0xF0) == 16))
        || (((($this->address >> 24) & 0xFF) == 192)
        && ((($this->address >> 16) & 0xFF) == 168));
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
        // 224.0.1.0 to 238.255.255.255
        $byteAddr = $this->getAddress();
        return (($byteAddr[0] & 0xff) >= 224 && ($byteAddr[0] & 0xff) <= 238 ) &&
        !(($byteAddr[0] & 0xff) == 224 && $byteAddr[1] == 0 &&
        $byteAddr[2] == 0);
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
        // unless ttl == 0
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
        // 224.0.0/24 prefix and ttl == 1
        return ((($this->address >> 24) & 0xFF) == 224)
        && ((($this->address >> 16) & 0xFF) == 0)
        && ((($this->address >> 8) & 0xFF) == 0);
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
        // 239.255/16 prefix or ttl < 32
        return ((($this->address >> 24) & 0xFF) == 239)
        && ((($this->address >> 16) & 0xFF) == 255);
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
        // 239.192 - 239.195
        return ((($this->address >> 24) & 0xFF) == 239)
        && ((($this->address >> 16) & 0xFF) >= 192)
        && ((($this->address >> 16) & 0xFF) <= 195);
    }

    /**
     * Returns the raw IP address of this <code>InetAddress</code>
     * object. The result is in network byte order: the highest order
     * byte of the address is in <code>getAddress()[0]</code>.
     *
     * @return  the raw IP address of this object.
     */
    public function getAddress() {
        $addr = new ArrayObject(self::INADDRSZ);

        $addr[0] = (($this->address >> 24) & 0xFF);
        $addr[1] = (($this->address >> 16) & 0xFF);
        $addr[2] = (($this->address >> 8) & 0xFF);
        $addr[3] = ($this->address & 0xFF);
        return $addr;
    }

    /**
     * Returns the IP address string in textual presentation form.
     *
     * @return  the raw IP address in a string format.
     * @since   JDK1.0.2
     */
    public function getHostAddress() {
        return self::numericToTextFormat($this->getAddress());
    }

    /**
     * Returns a hashcode for this IP address.
     *
     * @return  a hash code value for this IP address.
     */
    public function hashCode() {
        return $this->address;
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
     * @return  <code>true</code> if the objects are the same;
     *          <code>false</code> otherwise.
     * @see     java.net.InetAddress#getAddress()
     */
    public function equals(Object $obj) {
        return ($obj != null) && ($obj instanceof Inet4Address) &&
        ($obj->address == $this->address);
    }

    // Utilities
    /*
     * Converts IPv4 binary address into a string suitable for presentation.
     *
     * @param src a byte array representing an IPv4 numeric address
     * @return a String representing the IPv4 address in
     *         textual representation format
     * @since 1.4
     */

    private static function numericToTextFormat($src) {
        return ($src[0] & 0xff) + "." + ($src[1] & 0xff) + "." + ($src[2] & 0xff) + "." + ($src[3] & 0xff);
    }

}

?>
