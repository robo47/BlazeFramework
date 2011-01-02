<?php

namespace blaze\net;

/**
 * Description of URLStreamHandlerFactory
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class URLStreamHandler extends \blaze\lang\Object{
    /**
     * @return int
     */
    public function getDefaultPort(){
        return -1;
    }
    /**
     * @param URL $u
     * @return blaze\lang\String
     */
    public function toExternalForm(URL $u){
        $str = $u->getScheme().'://';

        if($u->getUser() != null){
            $str .= $u->getUser();

            if($u->getPassword() != null)
                    $str .= ':'.$u->getPassword();

            $str .= '@';
        }

        $str .= $u->getHost();

        if($u->getPort() != -1)
                $str .= ':'.$u->getPort();

        if($u->getPath() != null)
                $str .= '/'.$u->getPath();
        if($u->getQuery() != null)
                $str .= '?'.$u->getQuery();
        if($u->getFragment() != null)
                $str .= '#'.$u->getFragment();

        return new \blaze\lang\String($str);
    }
    /**
     * @param URL $u
     * @param Proxy $p
     * @return URLConnection
     */
    public function openConnection(URL $u, Proxy $p = null);

    public function equals(URL $u1, URL $u2) {
        $str1 = $u1->getUrlString();
        $str2 = $u2->getUrlString();

        return $str1 == $str2 || $str1->equals($str2);
    }



    public function hashCode(URL $u) {
        $h = 0;

        // Generate the protocol part.
        $protocol = $u->getProtocol();
        if ($protocol != null)
	    $h += $protocol->hashCode();

        // Generate the host part.
	$addr = $this->getHostAddress($u);
	if ($addr != null) {
	    $h += $addr->hashCode();
	} else {
            $host = $u->getHost();
            if ($host != null)
	        $h += $host->toLowerCase()->hashCode();
        }

        // Generate the port part.
	if ($u->getPort() == -1)
            $h += $this->getDefaultPort();
	else
            $h += $u->getPort();

        // Generate the path part.
        $p = $u->getPath();
	if ($p != null)
	    $h += $p->hashCode();

        // Generate the query part.
        $q = $u->getQuery();
	if ($q != null)
            $h += $q->hashCode();

        // Generate the query part.
        $f = $u->getFragment();
	if ($f != null)
            $h += $f->hashCode();

	return $h;
    }

    /**
     * Compare two urls to see whether they refer to the same file,
     * i.e., having the same protocol, host, port, and path.
     * This method requires that none of its arguments is null. This is
     * guaranteed by the fact that it is only called indirectly
     * by java.net.URL class.
     * @param u1 a URL object
     * @param u2 a URL object
     * @return boolean true if u1 and u2 refer to the same file
     * @since 1.3
     */
    public function sameFile(URL $u1, URL $u2) {
        // Compare the protocols.
        if (!(($u1.getProtocol() == $u2.getProtocol()) ||
              ($u1.getProtocol() != null &&
               $u1.getProtocol().equalsIgnoreCase($u2.getProtocol()))))
            return false;

	// Compare the files.
	if (!($u1.getFile() == $u2.getFile() ||
              ($u1.getFile() != null && $u1.getFile().equals($u2.getFile()))))
	    return false;

	// Compare the ports.
        $port1 = ($u1.getPort() != -1) ? $u1.getPort() : $u1.handler.getDefaultPort();
        $port2 = ($u2.getPort() != -1) ? $u2.getPort() : $u2.handler.getDefaultPort();
	if ($port1 != $port2)
	    return false;

	// Compare the hosts.
	if (!$this->hostsEqual($u1, $u2))
            return false;

        return true;
    }

    /**
     * Get the IP address of our host. An empty host field or a DNS failure
     * will result in a null return.
     *
     * @param u a URL object
     * @return InetAddress an <code>InetAddress</code> representing the host
     * IP address.
     * @since 1.3
     */
    public function getHostAddress(URL $u) {
	if ($u->hostAddress != null)
            return $u->hostAddress;

        $host = $u->getHost();
        if ($host == null || $host->equals("")) {
            return null;
        } else {
            try {
                $u->hostAddress = InetAddress::getByName($host);
//            } catch (UnknownHostException $ex) {
//                return null;
//            } catch (SecurityException $se) {
//                return null;
            } catch (\blaze\lang\Exception $e){
                return null;
            }
        }
	return $u->hostAddress;
    }

    /**
     * Compares the host components of two URLs.
     * @param u1 the URL of the first host to compare
     * @param u2 the URL of the second host to compare
     * @return	<tt>true</tt> if and only if they
     * are equal, <tt>false</tt> otherwise.
     * @since 1.3
     */
    public function hostsEqual(URL $u1, URL $u2) {
	$a1 = $this->getHostAddress($u1);
        $a2 = $this->getHostAddress($u2);
	// if we have internet address for both, compare them
	if ($a1 != null && $a2 != null) {
	    return $a1->equals($a2);
        // else, if both have host names, compare them
	} else if ($u1->getHost() != null && $u2->getHost() != null)
            return $u1->getHost()->equalsIgnoreCase($u2->getHost());
	 else
            return $u1->getHost() == null && $u2->getHost() == null;
    }

}

?>
