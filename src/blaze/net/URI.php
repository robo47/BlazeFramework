<?php

namespace blaze\net;

use blaze\lang\Object;

/**
 * Description of URI
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class URI extends Object implements \blaze\lang\Comparable, \blaze\io\Serializable{

    /**
     *
     * @var blaze\lang\String
     */
    private $scheme;
    /**
     *
     * @var blaze\lang\String
     */
    private $schemeSpecificPart;
    /**
     *
     * @var blaze\net\URL
     */
    private $url;
    /**
     *
     * @var blaze\lang\String
     */
    private $fragment;
    /**
     *
     * @var blaze\lang\String
     */
    private $uriString;
    /**
     * 0 is not set
     * @var int
     */
    private $hash;

    /**
     *
     * @param blaze\lang\String|string $scheme
     * @param blaze\lang\String|string|blaze\net\URL $sspOrUrl
     * @param blaze\lang\String|string $fragment
     */
    public function __construct($scheme, $sspOrUrl, $fragment = null) {
        $this->scheme = $scheme !== null ? \blaze\lang\String::asWrapper($scheme) : null;
        $this->fragment = $fragment !== null ? \blaze\lang\String::asWrapper($fragment) : null;

        if($sspOrUrl instanceof URL){
            $this->url = $sspOrUrl;
            if($this->scheme == null)
                    $this->scheme = $this->url->getScheme();
            $this->schemeSpecificPart = $this->url->getUrlString()->substring($this->url->getScheme()->length() + 1);

            if($this->fragmet == null)
                    $this->fragment = $this->url->getFragment();
            $this->uriString = $this->url->getUrlString();
        }else{
            $this->schemeSpecificPart = $sspOrUrl !== null ? \blaze\lang\String::asWrapper($sspOrUrl) : null;
        }

        $this->buildUrl();
    }

    /**
     * Description
     *
     * @param 	blaze\lang\String|string $uri Description of the parameter $var
     * @return 	blaze\net\URI Description of what the method returns
     * @throws	blaze\lang\Exception
     */
    public static function parseURI($uri) {
        $uri = \blaze\lang\String::asWrapper($uri);
        $idx = $uri->indexOf(':');

        if ($idx == -1 || $idx === $uri->length())
            throw new \blaze\lang\Exception('Invalid URI');

        $scheme = $uri->substring(0, $idx);
        $ssp = $uri->substring($idx + 1);
        $idx = $ssp->lastIndexOf('#');
        $fragment = null;
        
        if($idx !== -1){
            $fragment = $ssp->substring ($idx + 1);
            $ssp = $ssp->substring(0, $idx);
        }
        
        return new URI($scheme, $ssp, $fragment);
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getScheme() {
        return $this->url !== null ? $this->url->getScheme() : $this->scheme;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getSchemeSpecificPart() {
        return $this->schemeSpecificPart;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getUser() {
        return $this->url !== null ? $this->url->getUser() : null;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getPassword() {
        return $this->url !== null ? $this->url->getPassword() : null;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getHost() {
        return $this->url !== null ? $this->url->getHost() : null;
    }

    /**
     *
     * @return int
     */
    public function getPort() {
        return $this->url !== null ? $this->url->getPort() : null;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getPath() {
        return $this->url !== null ? $this->url->getPath() : null;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getQuery() {
        return $this->url !== null ? $this->url->getQuery() : null;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getFragment() {
        return $this->url !== null ? $this->url->getFragment() : $this->fragment;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getUriString() {
        return $this->uriString;
    }

    public function isOpaque(){
        return $this->url === null;
    }

    private function buildUrl() {
        if ($this->scheme === null || $this->scheme->length() == 0)
            throw new \blaze\lang\IllegalArgumentException('Scheme is not given!');
        if ($this->schemeSpecificPart === null || $this->schemeSpecificPart->length() == 0)
            throw new \blaze\lang\IllegalArgumentException('Scheme specific part is not given!');

        if($this->url === null){
            $this->uriString = $this->scheme . ':' . $this->schemeSpecificPart;

            if ($this->fragment != null)
                $this->uriString .= '#' . $this->fragment;

            $this->uriString = new \blaze\lang\String($this->uriString);
            
            try{
                $this->url = URL::parseURL($this->uriString);
            }catch(\blaze\lang\Exception $e){}
        }
    }

    public function equals(\blaze\lang\Reflectable $obj) {
        if($obj === $this)
            return true;
        if($obj == null || !$obj instanceof URI)
            return false;
        if($this->url != null && $obj->url != null)
                return $this->url->equals($obj);

        $fragmetOk = true;
        if($this->fragment != null xor $obj->fragment != null)
                $fragmetOk = false;
        if($fragmetOk && $this->fragment != null && $obj->fragment != null)
                $fragmetOk = $this->fragment->equals($obj->fragment);
        return $this->scheme->equalsIgnoreCase($obj->scheme) &&
               $this->schemeSpecificPart->equals($obj->schemeSpecificPart) &&
               $fragmetOk;
    }

    public function hashCode() {
        if($this->hash != 0)
                return $this->hash;

        $h = self::hashIgnoringCase(0, $this->scheme);
	$h = self::hash($h, $this->fragment);
	if ($this->isOpaque()) {
	    $h = self::hash($h, $this->schemeSpecificPart);
	} else {
	    $h = self::hash($h, $this->url->hashCode());
	}

	$this->hash = $h;
	return $h;
    }


    private static function hash($hash, \blaze\lang\String $s = null) {
	if ($s == null) return $hash;
	return $hash * 127 + $s->hashCode();
    }

    // US-ASCII only
    private static function hashIgnoringCase($hash, \blaze\lang\String $s) {
	if ($s == null) return $hash;
	$h = $hash;
	$n = $s->length();
	for ($i = 0; $i < $n; $i++)
	    $h = 31 * $h + self::toLower($s->charAt($i));
	return $h;
    }

    // US-ASCII only
    private static function toLower($c) {
	if (($c >= 'A') && ($c <= 'Z'))
	    return $c + ('a' - 'A');
	return $c;
    }

    public function toString() {
        return $this;
    }

    public function toURL() {
        if($this->url != null)
            return new URL ($this->url->getScheme(), $this->url->getUser(), $this->url->getPassword(), $this->url->getHost(), $this->url->getPort(), $this->url->getPath(), $this->url->getQuery(), $this->url->getFragment());
        else
            return URL::parseURL($this->uriString);
    }

    public function compareTo(Object $that) {
        if(!$that instanceof URI)
            throw new \blaze\lang\IllegalArgumentException('Parameters must be of the type blaze\\net\\URI');
        $c = 0;

	if (($c = self::compareIgnoringCase($this->scheme, $that->scheme)) != 0)
	    return $c;

	if ($this->isOpaque()) {
	    if ($that->isOpaque()) {
		// Both opaque
		if (($c = self::compare($this->schemeSpecificPart,
				 $that->schemeSpecificPart)) != 0)
		    return $c;
		return self::compare($this->fragment, $that->fragment);
	    }
	    return +1;			// Opaque > hierarchical
	} else if ($that->isOpaque()) {
	    return -1;			// Hierarchical < opaque
	}

	return $this->url->compareTo($that);
    }

    public static function compare($obj1, $obj2) {
	if ($obj1 === $obj2) return 0;
	if ($obj1 !== null) {
	    if ($obj2 !== null)
		return \blaze\lang\String::asWrapper($obj1)->compareTo($obj2);
	    else
		return +1;
	} else {
	    return -1;
	}
    }

    // US-ASCII only
    private static function compareIgnoringCase(String $s, String $t) {
	if ($s == $t) return 0;
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


    /**
     * Normalizes this URI's path.
     *
     * <p> If this URI is opaque, or if its path is already in normal form,
     * then this URI is returned.  Otherwise a new URI is constructed that is
     * identical to this URI except that its path is computed by normalizing
     * this URI's path in a manner consistent with <a
     * href="http://www.ietf.org/rfc/rfc2396.txt">RFC&nbsp;2396</a>,
     * section&nbsp;5.2, step&nbsp;6, sub-steps&nbsp;c through&nbsp;f; that is:
     * </p>
     *
     * <ol>
     *
     *   <li><p> All <tt>"."</tt> segments are removed. </p></li>
     *
     *   <li><p> If a <tt>".."</tt> segment is preceded by a non-<tt>".."</tt>
     *   segment then both of these segments are removed.  This step is
     *   repeated until it is no longer applicable. </p></li>
     *
     *   <li><p> If the path is relative, and if its first segment contains a
     *   colon character (<tt>':'</tt>), then a <tt>"."</tt> segment is
     *   prepended.  This prevents a relative URI with a path such as
     *   <tt>"a:b/c/d"</tt> from later being re-parsed as an opaque URI with a
     *   scheme of <tt>"a"</tt> and a scheme-specific part of <tt>"b/c/d"</tt>.
     *   <b><i>(Deviation from RFC&nbsp;2396)</i></b> </p></li>
     *
     * </ol>
     *
     * <p> A normalized path will begin with one or more <tt>".."</tt> segments
     * if there were insufficient non-<tt>".."</tt> segments preceding them to
     * allow their removal.  A normalized path will begin with a <tt>"."</tt>
     * segment if one was inserted by step 3 above.  Otherwise, a normalized
     * path will not contain any <tt>"."</tt> or <tt>".."</tt> segments. </p>
     *
     * @return  A URI equivalent to this URI,
     *          but whose path is in normal form
     */
//    public function normalize() {
//
//    }

    /**
     * Resolves the given URI against this URI.
     *
     * <p> If the given URI is already absolute, or if this URI is opaque, then
     * the given URI is returned.
     *
     * <p><a name="resolve-frag"></a> If the given URI's fragment component is
     * defined, its path component is empty, and its scheme, authority, and
     * query components are undefined, then a URI with the given fragment but
     * with all other components equal to those of this URI is returned.  This
     * allows a URI representing a standalone fragment reference, such as
     * <tt>"#foo"</tt>, to be usefully resolved against a base URI.
     *
     * <p> Otherwise this method constructs a new hierarchical URI in a manner
     * consistent with <a
     * href="http://www.ietf.org/rfc/rfc2396.txt">RFC&nbsp;2396</a>,
     * section&nbsp;5.2; that is: </p>
     *
     * <ol>
     *
     *   <li><p> A new URI is constructed with this URI's scheme and the given
     *   URI's query and fragment components. </p></li>
     *
     *   <li><p> If the given URI has an authority component then the new URI's
     *   authority and path are taken from the given URI. </p></li>
     *
     *   <li><p> Otherwise the new URI's authority component is copied from
     *   this URI, and its path is computed as follows: </p></li>
     *
     *   <ol type=a>
     *
     *     <li><p> If the given URI's path is absolute then the new URI's path
     *     is taken from the given URI. </p></li>
     *
     *     <li><p> Otherwise the given URI's path is relative, and so the new
     *     URI's path is computed by resolving the path of the given URI
     *     against the path of this URI.  This is done by concatenating all but
     *     the last segment of this URI's path, if any, with the given URI's
     *     path and then normalizing the result as if by invoking the {@link
     *     #normalize() normalize} method. </p></li>
     *
     *   </ol>
     *
     * </ol>
     *
     * <p> The result of this method is absolute if, and only if, either this
     * URI is absolute or the given URI is absolute.  </p>
     *
     * @param URI|blaze\lang\String|string $uri  The URI to be resolved against this URI
     * @return The resulting URI
     *
     * @throws  NullPointerException
     *          If <tt>uri</tt> is <tt>null</tt>
     */
//    public function resolve($uri) {
//	if(!$uri instanceof URI)
//            $uri = URI::parseURI($uri);
//
//    }

    /**
     * Relativizes the given URI against this URI.
     *
     * <p> The relativization of the given URI against this URI is computed as
     * follows: </p>
     *
     * <ol>
     *
     *   <li><p> If either this URI or the given URI are opaque, or if the
     *   scheme and authority components of the two URIs are not identical, or
     *   if the path of this URI is not a prefix of the path of the given URI,
     *   then the given URI is returned. </p></li>
     *
     *   <li><p> Otherwise a new relative hierarchical URI is constructed with
     *   query and fragment components taken from the given URI and with a path
     *   component computed by removing this URI's path from the beginning of
     *   the given URI's path. </p></li>
     *
     * </ol>
     *
     * @param  uri  The URI to be relativized against this URI
     * @return The resulting URI
     *
     * @throws  NullPointerException
     *          If <tt>uri</tt> is <tt>null</tt>
     */
//    public function relativize(URI $uri) {
//
//    }


    // -- Normalization, resolution, and relativization --

    // RFC2396 5.2 (6)
    private static function resolvePath(String $base, String $child, $absolute)
    {
//        int i = base.lastIndexOf('/');
//	int cn = child.length();
//	String path = "";
//
//	if (cn == 0) {
//	    // 5.2 (6a)
//	    if (i >= 0)
//		path = base.substring(0, i + 1);
//	} else {
//	    StringBuffer sb = new StringBuffer(base.length() + cn);
//	    // 5.2 (6a)
//	    if (i >= 0)
//		sb.append(base.substring(0, i + 1));
//	    // 5.2 (6b)
//	    sb.append(child);
//	    path = sb.toString();
//	}
//
//	// 5.2 (6c-f)
//	String np = normalize(path);
//
//	// 5.2 (6g): If the result is absolute but the path begins with "../",
//	// then we simply leave the path as-is
//
//	return np;
    }

    // RFC2396 5.2
    private static function resolve(URI $base, URI $child) {
//	// check if child if opaque first so that NPE is thrown
//	// if child is null.
//	if (child.isOpaque() || base.isOpaque())
//	    return child;
//
//	// 5.2 (2): Reference to current document (lone fragment)
//	if ((child.scheme == null) && (child.authority == null)
//	    && child.path.equals("") && (child.fragment != null)
//	    && (child.query == null)) {
//	    if ((base.fragment != null)
//		&& child.fragment.equals(base.fragment)) {
//		return base;
//	    }
//	    URI ru = new URI();
//	    ru.scheme = base.scheme;
//	    ru.authority = base.authority;
//	    ru.userInfo = base.userInfo;
//	    ru.host = base.host;
//	    ru.port = base.port;
//	    ru.path = base.path;
//	    ru.fragment = child.fragment;
//	    ru.query = base.query;
//	    return ru;
//	}
//
//	// 5.2 (3): Child is absolute
//	if (child.scheme != null)
//	    return child;
//
//	URI ru = new URI();		// Resolved URI
//	ru.scheme = base.scheme;
//	ru.query = child.query;
//	ru.fragment = child.fragment;
//
//	// 5.2 (4): Authority
//	if (child.authority == null) {
//	    ru.authority = base.authority;
//	    ru.host = base.host;
//	    ru.userInfo = base.userInfo;
//	    ru.port = base.port;
//
//	    String cp = (child.path == null) ? "" : child.path;
//	    if ((cp.length() > 0) && (cp.charAt(0) == '/')) {
//		// 5.2 (5): Child path is absolute
//		ru.path = child.path;
//	    } else {
//		// 5.2 (6): Resolve relative path
//		ru.path = resolvePath(base.path, cp, base.isAbsolute());
//	    }
//	} else {
//	    ru.authority = child.authority;
//	    ru.host = child.host;
//	    ru.userInfo = child.userInfo;
//	    ru.host = child.host;
//	    ru.port = child.port;
//	    ru.path = child.path;
//	}
//
//	// 5.2 (7): Recombine (nothing to do here)
//	return ru;
    }

    // If the given URI's path is normal then return the URI;
    // o.w., return a new URI containing the normalized path.
    //
    private static function normalize0(URI $u) {
//	if (u.isOpaque() || (u.path == null) || (u.path.length() == 0))
//	    return u;
//
//	String np = normalize(u.path);
//	if (np == u.path)
//	    return u;
//
//	URI v = new URI();
//	v.scheme = u.scheme;
//	v.fragment = u.fragment;
//	v.authority = u.authority;
//	v.userInfo = u.userInfo;
//	v.host = u.host;
//	v.port = u.port;
//	v.path = np;
//	v.query = u.query;
//	return v;
    }

    // If both URIs are hierarchical, their scheme and authority components are
    // identical, and the base path is a prefix of the child's path, then
    // return a relative URI that, when resolved against the base, yields the
    // child; otherwise, return the child.
    //
    private static function relativize(URI $base, URI $child) {
//	// check if child if opaque first so that NPE is thrown
//        // if child is null.
//	if (child.isOpaque() || base.isOpaque())
//	    return child;
//	if (!equalIgnoringCase(base.scheme, child.scheme)
//	    || !equal(base.authority, child.authority))
//	    return child;
//
//	String bp = normalize(base.path);
//	String cp = normalize(child.path);
//	if (!bp.equals(cp)) {
//	    if (!bp.endsWith("/"))
//		bp = bp + "/";
//	    if (!cp.startsWith(bp))
//		return child;
//	}
//
//	URI v = new URI();
//	v.path = cp.substring(bp.length());
//	v.query = child.query;
//	v.fragment = child.fragment;
//	return v;
    }



    // -- Path normalization --

    // The following algorithm for path normalization avoids the creation of a
    // string object for each segment, as well as the use of a string buffer to
    // compute the final result, by using a single char array and editing it in
    // place.  The array is first split into segments, replacing each slash
    // with '\0' and creating a segment-index array, each element of which is
    // the index of the first char in the corresponding segment.  We then walk
    // through both arrays, removing ".", "..", and other segments as necessary
    // by setting their entries in the index array to -1.  Finally, the two
    // arrays are used to rejoin the segments and compute the final result.
    //
    // This code is based upon src/solaris/native/java/io/canonicalize_md.c


    // Check the given path to see if it might need normalization.  A path
    // might need normalization if it contains duplicate slashes, a "."
    // segment, or a ".." segment.  Return -1 if no further normalization is
    // possible, otherwise return the number of segments found.
    //
    // This method takes a string argument rather than a char array so that
    // this test can be performed without invoking path.toCharArray().
    //
    private static function needsNormalization(String $path) {
//	boolean normal = true;
//	int ns = 0;			// Number of segments
//	int end = path.length() - 1;	// Index of last char in path
//	int p = 0;			// Index of next char in path
//
//	// Skip initial slashes
//	while (p <= end) {
//	    if (path.charAt(p) != '/') break;
//	    p++;
//	}
//	if (p > 1) normal = false;
//
//	// Scan segments
//	while (p <= end) {
//
//	    // Looking at "." or ".." ?
//	    if ((path.charAt(p) == '.')
//		&& ((p == end)
//		    || ((path.charAt(p + 1) == '/')
//			|| ((path.charAt(p + 1) == '.')
//			    && ((p + 1 == end)
//				|| (path.charAt(p + 2) == '/')))))) {
//		normal = false;
//	    }
//	    ns++;
//
//	    // Find beginning of next segment
//	    while (p <= end) {
//		if (path.charAt(p++) != '/')
//		    continue;
//
//		// Skip redundant slashes
//		while (p <= end) {
//		    if (path.charAt(p) != '/') break;
//		    normal = false;
//		    p++;
//		}
//
//		break;
//	    }
//	}
//
//	return normal ? -1 : ns;
    }


    // Split the given path into segments, replacing slashes with nulls and
    // filling in the given segment-index array.
    //
    // Preconditions:
    //   segs.length == Number of segments in path
    //
    // Postconditions:
    //   All slashes in path replaced by '\0'
    //   segs[i] == Index of first char in segment i (0 <= i < segs.length)
    //
    private static function split($path, $segs) {
//	int end = path.length - 1;	// Index of last char in path
//	int p = 0;			// Index of next char in path
//	int i = 0;			// Index of current segment
//
//	// Skip initial slashes
//	while (p <= end) {
//	    if (path[p] != '/') break;
//	    path[p] = '\0';
//	    p++;
//	}
//
//	while (p <= end) {
//
//	    // Note start of segment
//	    segs[i++] = p++;
//
//	    // Find beginning of next segment
//	    while (p <= end) {
//		if (path[p++] != '/')
//		    continue;
//		path[p - 1] = '\0';
//
//		// Skip redundant slashes
//		while (p <= end) {
//		    if (path[p] != '/') break;
//		    path[p++] = '\0';
//		}
//		break;
//	    }
//	}
//
//	if (i != segs.length)
//	    throw new InternalError();	// ASSERT
    }


    // Join the segments in the given path according to the given segment-index
    // array, ignoring those segments whose index entries have been set to -1,
    // and inserting slashes as needed.  Return the length of the resulting
    // path.
    //
    // Preconditions:
    //   segs[i] == -1 implies segment i is to be ignored
    //   path computed by split, as above, with '\0' having replaced '/'
    //
    // Postconditions:
    //   path[0] .. path[return value] == Resulting path
    //
    static private function join($path, $segs) {
//	int ns = segs.length;		// Number of segments
//	int end = path.length - 1;	// Index of last char in path
//	int p = 0;			// Index of next path char to write
//
//	if (path[p] == '\0') {
//	    // Restore initial slash for absolute paths
//	    path[p++] = '/';
//	}
//
//	for (int i = 0; i < ns; i++) {
//	    int q = segs[i];		// Current segment
//	    if (q == -1)
//		// Ignore this segment
//		continue;
//
//	    if (p == q) {
//		// We're already at this segment, so just skip to its end
//		while ((p <= end) && (path[p] != '\0'))
//		    p++;
//		if (p <= end) {
//		    // Preserve trailing slash
//		    path[p++] = '/';
//		}
//	    } else if (p < q) {
//		// Copy q down to p
//		while ((q <= end) && (path[q] != '\0'))
//		    path[p++] = path[q++];
//		if (q <= end) {
//		    // Preserve trailing slash
//		    path[p++] = '/';
//		}
//	    } else
//		throw new InternalError(); // ASSERT false
//	}
//
//	return p;
    }


    // Remove "." segments from the given path, and remove segment pairs
    // consisting of a non-".." segment followed by a ".." segment.
    //
    private static function removeDots($path, $segs) {
//	int ns = segs.length;
//	int end = path.length - 1;
//
//	for (int i = 0; i < ns; i++) {
//	    int dots = 0;		// Number of dots found (0, 1, or 2)
//
//	    // Find next occurrence of "." or ".."
//	    do {
//		int p = segs[i];
//		if (path[p] == '.') {
//		    if (p == end) {
//			dots = 1;
//			break;
//		    } else if (path[p + 1] == '\0') {
//			dots = 1;
//			break;
//		    } else if ((path[p + 1] == '.')
//			       && ((p + 1 == end)
//				   || (path[p + 2] == '\0'))) {
//			dots = 2;
//			break;
//		    }
//		}
//		i++;
//	    } while (i < ns);
//	    if ((i > ns) || (dots == 0))
//		break;
//
//	    if (dots == 1) {
//		// Remove this occurrence of "."
//		segs[i] = -1;
//	    } else {
//		// If there is a preceding non-".." segment, remove both that
//		// segment and this occurrence of ".."; otherwise, leave this
//		// ".." segment as-is.
//		int j;
//		for (j = i - 1; j >= 0; j--) {
//		    if (segs[j] != -1) break;
//		}
//		if (j >= 0) {
//		    int q = segs[j];
//		    if (!((path[q] == '.')
//			  && (path[q + 1] == '.')
//			  && (path[q + 2] == '\0'))) {
//			segs[i] = -1;
//			segs[j] = -1;
//		    }
//		}
//	    }
//	}
    }


    // DEVIATION: If the normalized path is relative, and if the first
    // segment could be parsed as a scheme name, then prepend a "." segment
    //
    private static function maybeAddLeadingDot($path, $segs) {
//
//	if (path[0] == '\0')
//	    // The path is absolute
//	    return;
//
//	int ns = segs.length;
//	int f = 0;			// Index of first segment
//	while (f < ns) {
//	    if (segs[f] >= 0)
//		break;
//	    f++;
//	}
//	if ((f >= ns) || (f == 0))
//	    // The path is empty, or else the original first segment survived,
//	    // in which case we already know that no leading "." is needed
//	    return;
//
//	int p = segs[f];
//	while ((p < path.length) && (path[p] != ':') && (path[p] != '\0')) p++;
//	if (p >= path.length || path[p] == '\0')
//	    // No colon in first segment, so no "." needed
//	    return;
//
//	// At this point we know that the first segment is unused,
//	// hence we can insert a "." segment at that position
//	path[0] = '.';
//	path[1] = '\0';
//	segs[0] = 0;
    }


    // Normalize the given path string.  A normal path string has no empty
    // segments (i.e., occurrences of "//"), no segments equal to ".", and no
    // segments equal to ".." that are preceded by a segment not equal to "..".
    // In contrast to Unix-style pathname normalization, for URI paths we
    // always retain trailing slashes.
    //
    private static function normalize(String $ps) {
//
//	// Does this path need normalization?
//	int ns = needsNormalization(ps);	// Number of segments
//	if (ns < 0)
//	    // Nope -- just return it
//	    return ps;
//
//	char[] path = ps.toCharArray();		// Path in char-array form
//
//	// Split path into segments
//	int[] segs = new int[ns];		// Segment-index array
//	split(path, segs);
//
//	// Remove dots
//	removeDots(path, segs);
//
//	// Prevent scheme-name confusion
//	maybeAddLeadingDot(path, segs);
//
//	// Join the remaining segments and return the result
//	String s = new String(path, 0, join(path, segs));
//	if (s.equals(ps)) {
//	    // string was already normalized
//	    return ps;
//	}
//	return s;
    }
}

?>
