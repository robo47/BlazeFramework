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
final class Inet6Address extends InetAddress{
final static int INADDRSZ = 16;

/*
 * cached scope_id - for link-local address use only.
 */
private transient int cached_scope_id = 0;

/**
 * Holds a 128-bit (16 bytes) IPv6 address.
 *
 * @serial
 */
byte[] ipaddress;

/**
 * scope_id. The scope specified when the object is created. If the object is created
 * with an interface name, then the scope_id is not determined until the time it is needed.
 */
private int scope_id = 0;

/**
 * This will be set to true when the scope_id field contains a valid
 * integer scope_id.
 */
private boolean scope_id_set = false;

/**
 * scoped interface. scope_id is derived from this as the scope_id of the first 
 * address whose scope is the same as this address for the named interface. 
 */
private transient NetworkInterface scope_ifname = null;

/**
 * set if the object is constructed with a scoped interface instead of a
 * numeric scope id.
 */
private boolean scope_ifname_set = false;

private static final long serialVersionUID = 6880410070516793377L;

/*
 * Perform initializations.
 */
static {
init();
}

Inet6Address() {
super();
hostName = null;
ipaddress = new byte[INADDRSZ];
family = IPv6;
}

/* checking of value for scope_id should be done by caller 
 * scope_id must be >= 0, or -1 to indicate not being set 
 */
Inet6Address(String hostName, byte addr[], int scope_id) {
this.hostName = hostName;
if (addr.length == INADDRSZ) { // normal IPv6 address
family = IPv6;
ipaddress = (byte[])addr.clone();
}
if (scope_id >= 0) {
this.scope_id = scope_id;
scope_id_set = true;
}
}

Inet6Address(String hostName, byte addr[]) {
try {
initif (hostName, addr, null);
} catch (UnknownHostException e) {} /* cant happen if ifname is null */
}

Inet6Address (String hostName, byte addr[], NetworkInterface nif) throws UnknownHostException {
initif (hostName, addr, nif);
}

Inet6Address (String hostName, byte addr[], String ifname) throws UnknownHostException {
initstr (hostName, addr, ifname);
}

/**
 * Create an Inet6Address in the exact manner of {@link InetAddress#getByAddress(String,byte[])}
 * except that the IPv6 scope_id is set to the value corresponding to the given interface 
 * for the address type specified in <code>addr</code>. 
 * The call will fail with an UnknownHostException if the given interface does not have a numeric
 * scope_id assigned for the given address type (eg. link-local or site-local).
 * See <a href="Inet6Address.html#scoped">here</a> for a description of IPv6
 * scoped addresses.
 *
 * @param host the specified host
 * @param addr the raw IP address in network byte order
 * @param nif an interface this address must be associated with.
 * @return  an Inet6Address object created from the raw IP address.
 * @exception  UnknownHostException  if IP address is of illegal length, or if the interface
 * 		does not have a numeric scope_id assigned for the given address type.
 *
 * @since 1.5
 */
public static Inet6Address getByAddress(String host, byte[] addr, NetworkInterface nif)
throws UnknownHostException {
if (host != null && host.length() > 0 && host.charAt(0) == '[') {
if (host.charAt(host.length()-1) == ']') {
host = host.substring(1, host.length() -1);
}
}
if (addr != null) {
if (addr.length == Inet6Address.INADDRSZ) {
return new Inet6Address(host, addr, nif);
}
}
throw new UnknownHostException("addr is of illegal length");
}

/**
 * Create an Inet6Address in the exact manner of {@link InetAddress#getByAddress(String,byte[])}
 * except that the IPv6 scope_id is set to the given numeric value.
 * The scope_id is not checked to determine if it corresponds to any interface on the system.
 * See <a href="Inet6Address.html#scoped">here</a> for a description of IPv6
 * scoped addresses.
 *
 * @param host the specified host
 * @param addr the raw IP address in network byte order
 * @param scope_id the numeric scope_id for the address.
 * @return  an Inet6Address object created from the raw IP address.
 * @exception  UnknownHostException  if IP address is of illegal length.
 *
 * @since 1.5
 */
public static Inet6Address getByAddress(String host, byte[] addr, int scope_id)
throws UnknownHostException {
if (host != null && host.length() > 0 && host.charAt(0) == '[') {
if (host.charAt(host.length()-1) == ']') {
host = host.substring(1, host.length() -1);
}
}
if (addr != null) {
if (addr.length == Inet6Address.INADDRSZ) {
return new Inet6Address(host, addr, scope_id);
}
}
throw new UnknownHostException("addr is of illegal length");
}

private void initstr (String hostName, byte addr[], String ifname) throws UnknownHostException {
try {
NetworkInterface nif = NetworkInterface.getByName (ifname);
if (nif == null) {
throw new UnknownHostException ("no such interface " + ifname);
}
initif (hostName, addr, nif);
} catch (SocketException e) {
throw new UnknownHostException ("SocketException thrown" + ifname);
}
}

private void initif(String hostName, byte addr[], NetworkInterface nif) throws UnknownHostException {
this.hostName = hostName;
if (addr.length == INADDRSZ) { // normal IPv6 address
family = IPv6;
ipaddress = (byte[])addr.clone();
}
if (nif != null) {
this.scope_ifname = nif;
scope_ifname_set = true;
scope_id = deriveNumericScope (nif);
scope_id_set = true;
}
}

/* check the two Ipv6 addresses and return false if they are both
 * non global address types, but not the same.
 * (ie. one is sitelocal and the other linklocal) 
 * return true otherwise.
 */
private boolean differentLocalAddressTypes(Inet6Address other) {

if (isLinkLocalAddress() &&!other.isLinkLocalAddress()) {
return false;
}
if (isSiteLocalAddress() &&!other.isSiteLocalAddress()) {
return false;
}
return true;
}

private int deriveNumericScope (NetworkInterface ifc) throws UnknownHostException {
Enumeration addresses = ifc.getInetAddresses();
while (addresses.hasMoreElements()) {
InetAddress address = (InetAddress)addresses.nextElement();
if (!(address instanceof Inet6Address)) {
continue;
}
Inet6Address ia6_addr = (Inet6Address)address;
/* check if site or link local prefixes match */
if (!differentLocalAddressTypes(ia6_addr)){
/* type not the same, so carry on searching */
continue;
}
/* found a matching address - return its scope_id */
return ia6_addr.scope_id;
}
throw new UnknownHostException ("no scope_id found");
}

private int deriveNumericScope (String ifname) throws UnknownHostException {
Enumeration en;
try {
en = NetworkInterface.getNetworkInterfaces();
} catch (SocketException e) {
throw new UnknownHostException ("could not enumerate local network interfaces");
}
while (en.hasMoreElements()) {
NetworkInterface ifc = (NetworkInterface)en.nextElement();
if (ifc.getName().equals (ifname)) {
Enumeration addresses = ifc.getInetAddresses();
while (addresses.hasMoreElements()) {
InetAddress address = (InetAddress)addresses.nextElement();
if (!(address instanceof Inet6Address)) {
continue;
}
Inet6Address ia6_addr = (Inet6Address)address;
/* check if site or link local prefixes match */
if (!differentLocalAddressTypes(ia6_addr)){
/* type not the same, so carry on searching */
continue;
}
/* found a matching address - return its scope_id */
return ia6_addr.scope_id;
}
}
}
throw new UnknownHostException ("No matching address found for interface : " +ifname);
}

/**
 * restore the state of this object from stream
 * including the scope information, only if the
 * scoped interface name is valid on this system
 */
private void readObject(ObjectInputStream s)
throws IOException, ClassNotFoundException {
scope_ifname = null;
scope_ifname_set = false;
s.defaultReadObject();

if (ifname != null &&!"".equals (ifname)) {
try {
scope_ifname = NetworkInterface.getByName(ifname);
try {
scope_id = deriveNumericScope (scope_ifname);
} catch (UnknownHostException e) {
// should not happen
assert false;
}
} catch (SocketException e) {}

if (scope_ifname == null) {
/* the interface does not exist on this system, so we clear
 * the scope information completely */
scope_id_set = false;
scope_ifname_set = false;
scope_id = 0;
}
}
/* if ifname was not supplied, then the numeric info is used */

ipaddress = (byte[])ipaddress.clone();

// Check that our invariants are satisfied
if (ipaddress.length != INADDRSZ) {
throw new InvalidObjectException("invalid address length: "+
ipaddress.length);
}

if (family != IPv6) {
throw new InvalidObjectException("invalid address family type");
}
}

/**
 * Utility routine to check if the InetAddress is an IP multicast
 * address. 11111111 at the start of the address identifies the
 * address as being a multicast address.
 *
 * @return a <code>boolean</code> indicating if the InetAddress is
 * an IP multicast address
 * @since JDK1.1
 */
public boolean isMulticastAddress() {
return ((ipaddress[0] & 0xff) == 0xff);
}

/**
 * Utility routine to check if the InetAddress in a wildcard address.
 * @return a <code>boolean</code> indicating if the Inetaddress is
 *         a wildcard address.
 * @since 1.4
 */
public boolean isAnyLocalAddress() {
byte test = 0x00;
for (int i = 0;
i < INADDRSZ;
i++) {
test |= ipaddress[i];
}
return (test == 0x00);
}

/**
 * Utility routine to check if the InetAddress is a loopback address. 
 *
 * @return a <code>boolean</code> indicating if the InetAddress is 
 * a loopback address; or false otherwise.
 * @since 1.4
 */
public boolean isLoopbackAddress() {
byte test = 0x00;
for (int i = 0;
i < 15;
i++) {
test |= ipaddress[i];
}
return (test == 0x00) && (ipaddress[15] == 0x01);
}

/**
 * Utility routine to check if the InetAddress is an link local address. 
 *
 * @return a <code>boolean</code> indicating if the InetAddress is 
 * a link local address; or false if address is not a link local unicast address.
 * @since 1.4
 */
public boolean isLinkLocalAddress() {
return ((ipaddress[0] & 0xff) == 0xfe
&& (ipaddress[1] & 0xc0) == 0x80);
}

/**
 * Utility routine to check if the InetAddress is a site local address. 
 *
 * @return a <code>boolean</code> indicating if the InetAddress is 
 * a site local address; or false if address is not a site local unicast address.
 * @since 1.4
 */
public boolean isSiteLocalAddress() {
return ((ipaddress[0] & 0xff) == 0xfe
&& (ipaddress[1] & 0xc0) == 0xc0);
}

/**
 * Utility routine to check if the multicast address has global scope.
 *
 * @return a <code>boolean</code> indicating if the address has 
 *         is a multicast address of global scope, false if it is not 
 *         of global scope or it is not a multicast address
 * @since 1.4
 */
public boolean isMCGlobal() {
return ((ipaddress[0] & 0xff) == 0xff
&& (ipaddress[1] & 0x0f) == 0x0e);
}

/**
 * Utility routine to check if the multicast address has node scope.
 *
 * @return a <code>boolean</code> indicating if the address has 
 *         is a multicast address of node-local scope, false if it is not 
 *         of node-local scope or it is not a multicast address
 * @since 1.4
 */
public boolean isMCNodeLocal() {
return ((ipaddress[0] & 0xff) == 0xff
&& (ipaddress[1] & 0x0f) == 0x01);
}

/**
 * Utility routine to check if the multicast address has link scope.
 *
 * @return a <code>boolean</code> indicating if the address has 
 *         is a multicast address of link-local scope, false if it is not 
 *         of link-local scope or it is not a multicast address
 * @since 1.4
 */
public boolean isMCLinkLocal() {
return ((ipaddress[0] & 0xff) == 0xff
&& (ipaddress[1] & 0x0f) == 0x02);
}

/**
 * Utility routine to check if the multicast address has site scope.
 *
 * @return a <code>boolean</code> indicating if the address has 
 *         is a multicast address of site-local scope, false if it is not 
 *         of site-local scope or it is not a multicast address
 * @since 1.4
 */
public boolean isMCSiteLocal() {
return ((ipaddress[0] & 0xff) == 0xff
&& (ipaddress[1] & 0x0f) == 0x05);
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
public boolean isMCOrgLocal() {
return ((ipaddress[0] & 0xff) == 0xff
&& (ipaddress[1] & 0x0f) == 0x08);
}

/**
 * Returns the raw IP address of this <code>InetAddress</code>
 * object. The result is in network byte order: the highest order
 * byte of the address is in <code>getAddress()[0]</code>.
 *
 * @return  the raw IP address of this object.
 */
public byte[] getAddress() {
return (byte[])ipaddress.clone();
}

/**
 * Returns the numeric scopeId, if this instance is associated with
 * an interface. If no scoped_id is set, the returned value is zero.
 *
 * @return the scopeId, or zero if not set.
 * @since 1.5
 */
public int getScopeId () {
return scope_id;
}

/**
 * Returns the scoped interface, if this instance was created with
 * with a scoped interface.
 *
 * @return the scoped interface, or null if not set.
 * @since 1.5
 */
public NetworkInterface getScopedInterface () {
return scope_ifname;
}

/**
 * Returns the IP address string in textual presentation. If the instance was created 
 * specifying a scope identifier then the scope id is appended to the IP address preceded by 
 * a "%" (per-cent) character. This can be either a numeric value or a string, depending on which
 * was used to createthe instance.
 *
 * @return  the raw IP address in a string format.
 */
public String getHostAddress() {
String s = numericToTextFormat(ipaddress);
if (scope_ifname_set) { /* must check this first */
s = s + "%" + scope_ifname.getName();
} else if (scope_id_set) {
s = s + "%" + scope_id;
}
return s;
}

/**
 * Returns a hashcode for this IP address.
 *
 * @return  a hash code value for this IP address.
 */
public int hashCode() {
if (ipaddress != null) {

int hash = 0;
int i=0;
while (i<INADDRSZ) {
int j=0;
int component=0;
while (j<4 && i<INADDRSZ) {
component = (component << 8) + ipaddress[i];
j++;
i++;
}
hash += component;
}
return hash;

} else {
return 0;
}
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
public boolean equals(Object obj) {
if (obj == null ||
!(obj instanceof Inet6Address))
return false;

Inet6Address inetAddr = (Inet6Address)obj;

for (int i = 0;
i < INADDRSZ;
i++) {
if (ipaddress[i] != inetAddr.ipaddress[i])
return false;
}

return true;
}

/**
 * Utility routine to check if the InetAddress is an
 * IPv4 compatible IPv6 address. 
 *
 * @return a <code>boolean</code> indicating if the InetAddress is 
 * an IPv4 compatible IPv6 address; or false if address is IPv4 address.
 * @since 1.4
 */
public boolean isIPv4CompatibleAddress() {
if ((ipaddress[0] == 0x00) && (ipaddress[1] == 0x00) &&
(ipaddress[2] == 0x00) && (ipaddress[3] == 0x00) &&
(ipaddress[4] == 0x00) && (ipaddress[5] == 0x00) &&
(ipaddress[6] == 0x00) && (ipaddress[7] == 0x00) &&
(ipaddress[8] == 0x00) && (ipaddress[9] == 0x00) &&
(ipaddress[10] == 0x00) && (ipaddress[11] == 0x00)) {
return true;
}
return false;
}

// Utilities
private final static int INT16SZ = 2;
/*
 * Convert IPv6 binary address into presentation (printable) format.
 *
 * @param src a byte array representing the IPv6 numeric address
 * @return a String representing an IPv6 address in
 *         textual representation format
 * @since 1.4
 */
static String numericToTextFormat(byte[] src)
{
StringBuffer sb = new StringBuffer(39);
for (int i = 0;
i < (INADDRSZ / INT16SZ);
i++) {
sb.append(Integer.toHexString(((src[i<<1]<<8) & 0xff00)
| (src[(i<<1)+1] & 0xff)));
if (i < (INADDRSZ / INT16SZ) -1 ) {
sb.append(":");
}
}
return sb.toString();
}

/**
 * Perform class load-time initializations.
 */
private static native void init();

/**
 * Following field is only used during (de)/serialization
 */
private String ifname;

/**
 * default behavior is overridden in order to write the
 * scope_ifname field as a String, rather than a NetworkInterface
 * which is not serializable
 */
private synchronized void writeObject(java.io.ObjectOutputStream s)
throws IOException
{
if (scope_ifname_set) {
ifname = scope_ifname.getName();
}
s.defaultWriteObject();
}
}
?>
