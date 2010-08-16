<?php
namespace blaze\lang;

/**
 * Description of String
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Implementing and documenting.
 */
class String extends Object implements NativeWrapper {
    private $string;
    private $count;
    private $hash;

    /**
     *
     * @param blaze\lang\String|string $string
     */
    public function __construct($string, $beginIndex = 0, $endIndex = null){
        $string = self::asNative($string);
        $this->count = strlen($string);
        
        if($endIndex === null)
            $endIndex = $this->count;
	if ($beginIndex < 0) {
	    throw new StringIndexOutOfBoundsException($beginIndex);
	}
	if ($endIndex < 0) {
	    throw new StringIndexOutOfBoundsException($endIndex);
	}
	if ($endIndex > $this->count) {
	    throw new StringIndexOutOfBoundsException($endIndex);
	}
	if ($beginIndex > $endIndex) {
	    throw new StringIndexOutOfBoundsException($endIndex - $beginIndex);
	}
        $this->string = substr($string,$beginIndex,$endIndex - $beginIndex);
        if($this->string === false)
                $this->string = '';
        $this->count = strlen($this->string);
        $this->hash = 0;
    }
    public function toNative() {
        return $this->string;
    }
    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isNativeType($value) {
        return is_string($value);
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isWrapperType($value) {
        return $value instanceof String;
    }

    /**
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isType($value) {
        return self::isNativeType($value) || self::isWrapperType($value);
    }

    /**
     *
     * @param blaze\lang\String|string $value
     * @return string
     */
    public static function asNative($value){
        if($value instanceof String)
            return $value->toNative();
        else if(is_string($value))
            return $value;
        else
            return (string)$value;
    }

    /**
     *
     * @param blaze\lang\String|string $value
     * @return blaze\lang\String
     */
    public static function asWrapper($value){
        if($value instanceof String)
            return $value;
        else
            return new self((string)$value);
    }

    public function __toString(){
        return $this->string;
    }

    /**
     * Returns the length of this string.
     * The length is equal to the number of <a href="Character.html#unicode">Unicode
     * code units</a> in the string.
     *
     * @return integer the length of the sequence of characters represented by this
     *          object.
     */
    public function length() {
        return $this->count;
    }

    /**
     * Returns <tt>true</tt> if, and only if, {@link #length()} is <tt>0</tt>.
     *
     * @return boolean <tt>true</tt> if {@link #length()} is <tt>0</tt>, otherwise
     * <tt>false</tt>
     *
     * @since 1.6
     */
    public function isEmpty() {
	return $this->count == 0;
    }

    /**
     * Returns the <code>char</code> value at the
     * specified index. An index ranges from <code>0</code> to
     * <code>length() - 1</code>. The first <code>char</code> value of the sequence
     * is at index <code>0</code>, the next at index <code>1</code>,
     * and so on, as for array indexing.
     *
     * <p>If the <code>char</code> value specified by the index is a
     * <a href="Character.html#unicode">surrogate</a>, the surrogate
     * value is returned.
     *
     * @param      index   the index of the <code>char</code> value.
     * @return string    the <code>char</code> value at the specified index of this string.
     *             The first <code>char</code> value is at index <code>0</code>.
     * @exception  IndexOutOfBoundsException  if the <code>index</code>
     *             argument is negative or not less than the length of this
     *             string.
     */
    public function charAt($index) {

        if (($index < 0) || ($index >= $this->count)) {
            throw new StringIndexOutOfBoundsException($index);
        }
        return $this->string[$index];
    }

    /**
     * Copies characters from this string into the destination character
     * array.
     * <p>
     * The first character to be copied is at index <code>srcBegin</code>;
     * the last character to be copied is at index <code>srcEnd-1</code>
     * (thus the total number of characters to be copied is
     * <code>srcEnd-srcBegin</code>). The characters are copied into the
     * subarray of <code>dst</code> starting at index <code>dstBegin</code>
     * and ending at index:
     * <p><blockquote><pre>
     *     dstbegin + (srcEnd-srcBegin) - 1
     * </pre></blockquote>
     *
     * @param      srcBegin   index of the first character in the string
     *                        to copy.
     * @param      srcEnd     index after the last character in the string
     *                        to copy.
     * @param      dst        the destination array.
     * @param      dstBegin   the start offset in the destination array.
     * @exception IndexOutOfBoundsException If any of the following
     *            is true:
     *            <ul><li><code>srcBegin</code> is negative.
     *            <li><code>srcBegin</code> is greater than <code>srcEnd</code>
     *            <li><code>srcEnd</code> is greater than the length of this
     *                string
     *            <li><code>dstBegin</code> is negative
     *            <li><code>dstBegin+(srcEnd-srcBegin)</code> is larger than
     *                <code>dst.length</code></ul>
     */
//    public void getChars(int srcBegin, int srcEnd, char dst[], int dstBegin) {
//        if (srcBegin < 0) {
//            throw new StringIndexOutOfBoundsException(srcBegin);
//        }
//        if (srcEnd > count) {
//            throw new StringIndexOutOfBoundsException(srcEnd);
//        }
//        if (srcBegin > srcEnd) {
//            throw new StringIndexOutOfBoundsException(srcEnd - srcBegin);
//        }
//        System.arraycopy(value, offset + srcBegin, dst, dstBegin,
//             srcEnd - srcBegin);
//    }

    /**
     * Encodes this {@code String} into a sequence of bytes using the named
     * charset, storing the result into a new byte array.
     *
     * <p> The behavior of this method when this string cannot be encoded in
     * the given charset is unspecified.  The {@link
     * java.nio.charset.CharsetEncoder} class should be used when more control
     * over the encoding process is required.
     *
     * @param  charsetName
     *         The name of a supported {@linkplain java.nio.charset.Charset
     *         charset}
     *
     * @return  The resultant byte array
     *
     * @throws  UnsupportedEncodingException
     *          If the named charset is not supported
     *
     * @since  JDK1.1
     */
    public function getBytes(String $charsetName)
	//throws UnsupportedEncodingException
    {
//	if (charsetName == null) throw new NullPointerException();
//	return StringCoding.encode(charsetName, value, offset, count);
    }

    /**
     * Encodes this {@code String} into a sequence of bytes using the given
     * {@linkplain java.nio.charset.Charset charset}, storing the result into a
     * new byte array.
     *
     * <p> This method always replaces malformed-input and unmappable-character
     * sequences with this charset's default replacement byte array.  The
     * {@link java.nio.charset.CharsetEncoder} class should be used when more
     * control over the encoding process is required.
     *
     * @param  charset
     *         The {@linkplain java.nio.charset.Charset} to be used to encode
     *         the {@code String}
     *
     * @return  The resultant byte array
     *
     * @since  1.6
     */
//    public function getBytes(Charset $charset) {
//	if (charset == null) throw new NullPointerException();
//	return StringCoding.encode(charset, value, offset, count);
//    }

    /**
     * Encodes this {@code String} into a sequence of bytes using the
     * platform's default charset, storing the result into a new byte array.
     *
     * <p> The behavior of this method when this string cannot be encoded in
     * the default charset is unspecified.  The {@link
     * java.nio.charset.CharsetEncoder} class should be used when more control
     * over the encoding process is required.
     *
     * @return array[byte] The resultant byte array
     *
     * @since      JDK1.1
     */
//    public function getBytes() {
//	return StringCoding.encode(value, offset, count);
//    }

    /**
     * Compares this string to the specified object.  The result is {@code
     * true} if and only if the argument is not {@code null} and is a {@code
     * String} object that represents the same sequence of characters as this
     * object.
     *
     * @param  anObject
     *         The object to compare this {@code String} against
     *
     * @return boolean {@code true} if the given object represents a {@code String}
     *          equivalent to this string, {@code false} otherwise
     *
     * @see  #compareTo(String)
     * @see  #equalsIgnoreCase(String)
     */
    public function equals(Reflectable $obj) {
	if ($this == $obj) {
	    return true;
	}
	if ($obj instanceof String) {
	    if($this->string !== $obj->string)
                    return false;
            return true;
	}
	return false;
    }

    /**
     * Compares this string to the specified {@code StringBuffer}.  The result
     * is {@code true} if and only if this {@code String} represents the same
     * sequence of characters as the specified {@code StringBuffer}.
     *
     * @param  sb
     *         The {@code StringBuffer} to compare this {@code String} against
     *
     * @return boolean {@code true} if this {@code String} represents the same
     *          sequence of characters as the specified {@code StringBuffer},
     *          {@code false} otherwise
     *
     * @since  1.4
     */
//    public function contentEquals(StringBuffer $sb) {
//        synchronized(sb) {
//            return contentEquals((CharSequence)sb);
//        }
//    }

    /**
     * Compares this string to the specified {@code CharSequence}.  The result
     * is {@code true} if and only if this {@code String} represents the same
     * sequence of char values as the specified sequence.
     *
     * @param  cs
     *         The sequence to compare this {@code String} against
     *
     * @return boolean {@code true} if this {@code String} represents the same
     *          sequence of char values as the specified sequence, {@code
     *          false} otherwise
     *
     * @since  1.5
     */
    public function contentEquals(CharSequence $cs) {
//        if (count != cs.length())
//            return false;
//        // Argument is a StringBuffer, StringBuilder
//        if (cs instanceof AbstractStringBuilder) {
//            char v1[] = value;
//            char v2[] = ((AbstractStringBuilder)cs).getValue();
//            int i = offset;
//            int j = 0;
//            int n = count;
//            while (n-- != 0) {
//                if (v1[i++] != v2[j++])
//                    return false;
//            }
//        }
//        // Argument is a String
//        if (cs.equals(this))
//            return true;
//        // Argument is a generic CharSequence
//        char v1[] = value;
//        int i = offset;
//        int j = 0;
//        int n = count;
//        while (n-- != 0) {
//            if (v1[i++] != cs.charAt(j++))
//                return false;
//        }
//        return true;
    }

    /**
     * Compares this {@code String} to another {@code String}, ignoring case
     * considerations.  Two strings are considered equal ignoring case if they
     * are of the same length and corresponding characters in the two strings
     * are equal ignoring case.
     *
     * <p> Two characters {@code c1} and {@code c2} are considered the same
     * ignoring case if at least one of the following is true:
     * <ul>
     *   <li> The two characters are the same (as compared by the
     *        {@code ==} operator)
     *   <li> Applying the method {@link
     *        java.lang.Character#toUpperCase(char)} to each character
     *        produces the same result
     *   <li> Applying the method {@link
     *        java.lang.Character#toLowerCase(char)} to each character
     *        produces the same result
     * </ul>
     *
     * @param  $anotherString
     *         The {@code String} to compare this {@code String} against
     *
     * @return boolean {@code true} if the argument is not {@code null} and it
     *          represents an equivalent {@code String} ignoring case; {@code
     *          false} otherwise
     *
     * @see  #equals(Object)
     */
    public function equalsIgnoreCase($anotherString) {
        $anotherString = String::asNative($anotherString);
        return ($this->string == $anotherString) ? true :
                ($anotherString != null) && (strlen($anotherString) == $this->count) &&
                strcasecmp($this->string, $anotherString) == 0;
    }

    /**
     * Compares two strings lexicographically.
     * The comparison is based on the Unicode value of each character in
     * the strings. The character sequence represented by this
     * <code>String</code> object is compared lexicographically to the
     * character sequence represented by the argument string. The result is
     * a negative integer if this <code>String</code> object
     * lexicographically precedes the argument string. The result is a
     * positive integer if this <code>String</code> object lexicographically
     * follows the argument string. The result is zero if the strings
     * are equal; <code>compareTo</code> returns <code>0</code> exactly when
     * the {@link #equals(Object)} method would return <code>true</code>.
     * <p>
     * This is the definition of lexicographic ordering. If two strings are
     * different, then either they have different characters at some index
     * that is a valid index for both strings, or their lengths are different,
     * or both. If they have different characters at one or more index
     * positions, let <i>k</i> be the smallest such index; then the string
     * whose character at position <i>k</i> has the smaller value, as
     * determined by using the &lt; operator, lexicographically precedes the
     * other string. In this case, <code>compareTo</code> returns the
     * difference of the two character values at position <code>k</code> in
     * the two string -- that is, the value:
     * <blockquote><pre>
     * this.charAt(k)-anotherString.charAt(k)
     * </pre></blockquote>
     * If there is no index position at which they differ, then the shorter
     * string lexicographically precedes the longer string. In this case,
     * <code>compareTo</code> returns the difference of the lengths of the
     * strings -- that is, the value:
     * <blockquote><pre>
     * this.length()-anotherString.length()
     * </pre></blockquote>
     *
     * @param blaze\lang\String|string  anotherString   the <code>String</code> to be compared.
     * @return integer the value <code>0</code> if the argument string is equal to
     *          this string; a value less than <code>0</code> if this string
     *          is lexicographically less than the string argument; and a
     *          value greater than <code>0</code> if this string is
     *          lexicographically greater than the string argument.
     */
    public function compareTo($anotherString) {
        return strcmp($this->string, String::asNative($anotherString));
    }

    /**
     * A Comparator that orders <code>String</code> objects as by
     * <code>compareToIgnoreCase</code>. This comparator is serializable.
     * <p>
     * Note that this Comparator does <em>not</em> take locale into account,
     * and will result in an unsatisfactory ordering for certain locales.
     * The java.text package provides <em>Collators</em> to allow
     * locale-sensitive ordering.
     *
     * @see     java.text.Collator#compare(String, String)
     * @since   1.2
     */
//    public static final Comparator<String> CASE_INSENSITIVE_ORDER
//                                         = new CaseInsensitiveComparator();
//    private static class CaseInsensitiveComparator
//                         implements Comparator<String>, java.io.Serializable {
//	// use serialVersionUID from JDK 1.2.2 for interoperability
//	private static final long serialVersionUID = 8575799808933029326L;
//
//        public int compare(String s1, String s2) {
//            int n1=s1.length(), n2=s2.length();
//            for (int i1=0, i2=0; i1<n1 && i2<n2; i1++, i2++) {
//                char c1 = s1.charAt(i1);
//                char c2 = s2.charAt(i2);
//                if (c1 != c2) {
//                    c1 = Character.toUpperCase(c1);
//                    c2 = Character.toUpperCase(c2);
//                    if (c1 != c2) {
//                        c1 = Character.toLowerCase(c1);
//                        c2 = Character.toLowerCase(c2);
//                        if (c1 != c2) {
//                            return c1 - c2;
//                        }
//                    }
//                }
//            }
//            return n1 - n2;
//        }
//    }

    /**
     * Compares two strings lexicographically, ignoring case
     * differences. This method returns an integer whose sign is that of
     * calling <code>compareTo</code> with normalized versions of the strings
     * where case differences have been eliminated by calling
     * <code>Character.toLowerCase(Character.toUpperCase(character))</code> on
     * each character.
     * <p>
     * Note that this method does <em>not</em> take locale into account,
     * and will result in an unsatisfactory ordering for certain locales.
     * The java.text package provides <em>collators</em> to allow
     * locale-sensitive ordering.
     *
     * @param   str   the <code>String</code> to be compared.
     * @return integer a negative integer, zero, or a positive integer as the
     *		specified String is greater than, equal to, or less
     *		than this String, ignoring case considerations.
     * @see     java.text.Collator#compare(String, String)
     * @since   1.2
     */
    public function compareToIgnoreCase($anotherString) {
        return strcasecmp($this->string, String::asNative($anotherString));
    }

    /**
     * Tests if two string regions are equal.
     * <p>
     * A substring of this <tt>String</tt> object is compared to a substring
     * of the argument <tt>other</tt>. The result is <tt>true</tt> if these
     * substrings represent character sequences that are the same, ignoring
     * case if and only if <tt>ignoreCase</tt> is true. The substring of
     * this <tt>String</tt> object to be compared begins at index
     * <tt>toffset</tt> and has length <tt>len</tt>. The substring of
     * <tt>other</tt> to be compared begins at index <tt>ooffset</tt> and
     * has length <tt>len</tt>. The result is <tt>false</tt> if and only if
     * at least one of the following is true:
     * <ul><li><tt>toffset</tt> is negative.
     * <li><tt>ooffset</tt> is negative.
     * <li><tt>toffset+len</tt> is greater than the length of this
     * <tt>String</tt> object.
     * <li><tt>ooffset+len</tt> is greater than the length of the other
     * argument.
     * <li><tt>ignoreCase</tt> is <tt>false</tt> and there is some nonnegative
     * integer <i>k</i> less than <tt>len</tt> such that:
     * <blockquote><pre>
     * this.charAt(toffset+k) != other.charAt(ooffset+k)
     * </pre></blockquote>
     * <li><tt>ignoreCase</tt> is <tt>true</tt> and there is some nonnegative
     * integer <i>k</i> less than <tt>len</tt> such that:
     * <blockquote><pre>
     * Character.toLowerCase(this.charAt(toffset+k)) !=
               Character.toLowerCase(other.charAt(ooffset+k))
     * </pre></blockquote>
     * and:
     * <blockquote><pre>
     * Character.toUpperCase(this.charAt(toffset+k)) !=
     *         Character.toUpperCase(other.charAt(ooffset+k))
     * </pre></blockquote>
     * </ul>
     *
     * @param boolean  ignoreCase   if <code>true</code>, ignore case when comparing
     *                       characters.
     * @param integer  toffset      the starting offset of the subregion in this
     *                       string.
     * @param blaze\lang\String  other        the string argument.
     * @param integer  ooffset      the starting offset of the subregion in the string
     *                       argument.
     * @param integer   len          the number of characters to compare.
     * @return boolean <code>true</code> if the specified subregion of this string
     *          matches the specified subregion of the string argument;
     *          <code>false</code> otherwise. Whether the matching is exact
     *          or case insensitive depends on the <code>ignoreCase</code>
     *          argument.
     */
    public function regionMatches(String $other, $toffset, $ooffset,
                                           $len, $ignoreCase = false) {
        $ta = $this->string;
        $to = $toffset;
        $pa = $other->string;
        $po = $ooffset;
        // Note: toffset, ooffset, or len might be near -1>>>1.
        if (($ooffset < 0) || ($toffset < 0) || ($toffset > $this->count - $len) ||
                ($ooffset > $other->count - $len)) {
            return false;
        }
        while ($len-- > 0) {
            $c1 = $ta[$to];
            $c2 = $pa[$po];
            if ($c1 == $c2) {
                continue;
            }
            if ($ignoreCase) {
                // If characters don't match but case may be ignored,
                // try converting both characters to uppercase.
                // If the results match, then the comparison scan should
                // continue.
                if (ucfirst($c1) == ucfirst($c2)) {
                    continue;
                }
                // Unfortunately, conversion to uppercase does not work properly
                // for the Georgian alphabet, which has strange rules about case
                // conversion.  So we need to make one last check before
                // exiting.
//                if (Character.toLowerCase(u1) == Character.toLowerCase(u2)) {
//                    continue;
//                }
            }
            return false;
        }
        return true;
    }

    /**
     * Tests if the substring of this string beginning at the
     * specified index starts with the specified prefix.
     *
     * @param blaze\lang\String|string  prefix    the prefix.
     * @param   toffset   where to begin looking in this string.
     * @return boolean <code>true</code> if the character sequence represented by the
     *          argument is a prefix of the substring of this object starting
     *          at index <code>toffset</code>; <code>false</code> otherwise.
     *          The result is <code>false</code> if <code>toffset</code> is
     *          negative or greater than the length of this
     *          <code>String</code> object; otherwise the result is the same
     *          as the result of the expression
     *          <pre>
     *          this.substring(toffset).startsWith(prefix)
     *          </pre>
     */
    public function startsWith($prefix, $toffset = 0, $ignoreCase = false) {
        $prefix = String::asWrapper($prefix);
        if($ignoreCase){
            return strcasecmp(substr($this->string, $toffset, $prefix->count),$prefix->string)===0;
        }
        return strcmp(substr($this->string, $toffset, $prefix->count),$prefix->string)===0;

//	char ta[] = value;
//	int to = offset + toffset;
//	char pa[] = prefix.value;
//	int po = prefix.offset;
//	int pc = prefix.count;
//	// Note: toffset might be near -1>>>1.
//	if ((toffset < 0) || (toffset > count - pc)) {
//	    return false;
//	}
//	while (--pc >= 0) {
//	    if (ta[to++] != pa[po++]) {
//	        return false;
//	    }
//	}
//	return true;
    }

    /**
     * Tests if this string ends with the specified suffix.
     *
     * @param   suffix   the suffix.
     * @return boolean <code>true</code> if the character sequence represented by the
     *          argument is a suffix of the character sequence represented by
     *          this object; <code>false</code> otherwise. Note that the
     *          result will be <code>true</code> if the argument is the
     *          empty string or is equal to this <code>String</code> object
     *          as determined by the {@link #equals(Object)} method.
     */
    public function endsWith($suffix, $ignoreCase = false) {
        $suffix = String::asWrapper($suffix);
	return $this->startsWith($suffix, $this->count - $suffix->count, $ignoreCase);
    }

    /**
     * Returns a hash code for this string. The hash code for a
     * <code>String</code> object is computed as
     * <blockquote><pre>
     * s[0]*31^(n-1) + s[1]*31^(n-2) + ... + s[n-1]
     * </pre></blockquote>
     * using <code>int</code> arithmetic, where <code>s[i]</code> is the
     * <i>i</i>th character of the string, <code>n</code> is the length of
     * the string, and <code>^</code> indicates exponentiation.
     * (The hash value of the empty string is zero.)
     *
     * @return integer a hash code value for this object.
     */
    public function hashCode() {
	$h = $this->hash;
	if ($h == 0) {
	    $off = 0;
	    $val = $this->string;
	    $len = $this->count;

            for ($i = 0; $i < $len; $i++) {
                $h = 31*$h + $val[$off++];
            }
            $this->hash = $h;
        }
        return $h;
    }

    /**
     * Returns the index within this string of the first occurrence of
     * the specified character. If a character with value
     * <code>ch</code> occurs in the character sequence represented by
     * this <code>String</code> object, then the index (in Unicode
     * code units) of the first such occurrence is returned. For
     * values of <code>ch</code> in the range from 0 to 0xFFFF
     * (inclusive), this is the smallest value <i>k</i> such that:
     * <blockquote><pre>
     * this.charAt(<i>k</i>) == ch
     * </pre></blockquote>
     * is true. For other values of <code>ch</code>, it is the
     * smallest value <i>k</i> such that:
     * <blockquote><pre>
     * this.codePointAt(<i>k</i>) == ch
     * </pre></blockquote>
     * is true. In either case, if no such character occurs in this
     * string, then <code>-1</code> is returned.
     *
     * @param blaze\lang\String|string  ch   a character (Unicode code point).
     * @return integer the index of the first occurrence of the character in the
     *          character sequence represented by this object, or
     *          <code>-1</code> if the character does not occur.
     */
    public function indexOf($ch, $fromIndex = 0) {
        $pos = strpos($this->string, String::asNative($ch), $fromIndex);
        return $pos === false ? -1 : $pos;
    }

    /**
     * Returns the index within this string of the last occurrence of
     * the specified character. For values of <code>ch</code> in the
     * range from 0 to 0xFFFF (inclusive), the index (in Unicode code
     * units) returned is the largest value <i>k</i> such that:
     * <blockquote><pre>
     * this.charAt(<i>k</i>) == ch
     * </pre></blockquote>
     * is true. For other values of <code>ch</code>, it is the
     * largest value <i>k</i> such that:
     * <blockquote><pre>
     * this.codePointAt(<i>k</i>) == ch
     * </pre></blockquote>
     * is true.  In either case, if no such character occurs in this
     * string, then <code>-1</code> is returned.  The
     * <code>String</code> is searched backwards starting at the last
     * character.
     *
     * @param blaze\lang\String|string  ch   a character (Unicode code point).
     * @return integer the index of the last occurrence of the character in the
     *          character sequence represented by this object, or
     *          <code>-1</code> if the character does not occur.
     */
    public function lastIndexOf($ch, $fromIndex = null) {
	$pos = strrpos($this->string, String::asNative($ch), $fromIndex);
        return $pos === false ? -1 : $pos;
    }

    /**
     * Returns a new string that is a substring of this string. The
     * substring begins at the specified <code>beginIndex</code> and
     * extends to the character at index <code>endIndex - 1</code>.
     * Thus the length of the substring is <code>endIndex-beginIndex</code>.
     * <p>
     * Examples:
     * <blockquote><pre>
     * "hamburger".substring(4, 8) returns "urge"
     * "smiles".substring(1, 5) returns "mile"
     * </pre></blockquote>
     *
     * @param      beginIndex   the beginning index, inclusive.
     * @param      endIndex     the ending index, exclusive.
     * @return  blaze\lang\String    the specified substring.
     * @exception  IndexOutOfBoundsException  if the
     *             <code>beginIndex</code> is negative, or
     *             <code>endIndex</code> is larger than the length of
     *             this <code>String</code> object, or
     *             <code>beginIndex</code> is larger than
     *             <code>endIndex</code>.
     */
    public function substring($beginIndex, $endIndex = null) {
        if($endIndex === null) {
            $endIndex = $this->count;
        }
	if ($beginIndex < 0) {
	    throw new StringIndexOutOfBoundsException($beginIndex);
	}
        if ($endIndex < 0) {
	    throw new StringIndexOutOfBoundsException($endIndex);
	}
	if ($endIndex > $this->count) {
	    throw new StringIndexOutOfBoundsException($endIndex);
	}
	if ($beginIndex > $endIndex) {
	    throw new StringIndexOutOfBoundsException($endIndex - $beginIndex);
	}
	return (($beginIndex == 0) && ($endIndex == $this->count)) ? $this :
	    new String($this->string, $beginIndex, $endIndex);
    }

    /**
     * Concatenates the specified string to the end of this string.
     * <p>
     * If the length of the argument string is <code>0</code>, then this
     * <code>String</code> object is returned. Otherwise, a new
     * <code>String</code> object is created, representing a character
     * sequence that is the concatenation of the character sequence
     * represented by this <code>String</code> object and the character
     * sequence represented by the argument string.<p>
     * Examples:
     * <blockquote><pre>
     * "cares".concat("s") returns "caress"
     * "to".concat("get").concat("her") returns "together"
     * </pre></blockquote>
     *
     * @param   str   the <code>String</code> that is concatenated to the end
     *                of this <code>String</code>.
     * @return  blaze\lang\String a string that represents the concatenation of this object's
     *          characters followed by the string argument's characters.
     */
    public function concat($str) {
	return new String($this->string . String::asNative($str));
    }

    /**
     * Returns a new string resulting from replacing all occurrences of
     * <code>oldChar</code> in this string with <code>newChar</code>.
     * <p>
     * If the character <code>oldChar</code> does not occur in the
     * character sequence represented by this <code>String</code> object,
     * then a reference to this <code>String</code> object is returned.
     * Otherwise, a new <code>String</code> object is created that
     * represents a character sequence identical to the character sequence
     * represented by this <code>String</code> object, except that every
     * occurrence of <code>oldChar</code> is replaced by an occurrence
     * of <code>newChar</code>.
     * <p>
     * Examples:
     * <blockquote><pre>
     * "mesquite in your cellar".replace('e', 'o')
     *         returns "mosquito in your collar"
     * "the war of baronets".replace('r', 'y')
     *         returns "the way of bayonets"
     * "sparring with a purple porpoise".replace('p', 't')
     *         returns "starring with a turtle tortoise"
     * "JonL".replace('q', 'x') returns "JonL" (no change)
     * </pre></blockquote>
     *
     * @param   oldChar   the old character.
     * @param   newChar   the new character.
     * @return  blaze\lang\String a string derived from this string by replacing every
     *          occurrence of <code>oldChar</code> with <code>newChar</code>.
     */
    public function replace($oldChar, $newChar, $ignoreCase = false) {
        if($ignoreCase)
            return new String(str_ireplace(String::asNative($oldChar), String::asNative($newChar), $this->string));

        return new String(str_replace(String::asNative($oldChar), String::asNative($newChar), $this->string));
//	if (oldChar != newChar) {
//	    int len = count;
//	    int i = -1;
//	    char[] val = value; /* avoid getfield opcode */
//	    int off = offset;   /* avoid getfield opcode */
//
//	    while (++i < len) {
//		if (val[off + i] == oldChar) {
//		    break;
//		}
//	    }
//	    if (i < len) {
//		char buf[] = new char[len];
//		for (int j = 0 ; j < i ; j++) {
//		    buf[j] = val[off+j];
//		}
//		while (i < len) {
//		    char c = val[off + i];
//		    buf[i] = (c == oldChar) ? newChar : c;
//		    i++;
//		}
//		return new String(0, len, buf);
//	    }
//	}
//	return this;
    }

    /**
     * Tells whether or not this string matches the given <a
     * href="../util/regex/Pattern.html#sum">regular expression</a>.
     *
     * <p> An invocation of this method of the form
     * <i>str</i><tt>.matches(</tt><i>regex</i><tt>)</tt> yields exactly the
     * same result as the expression
     *
     * <blockquote><tt> {@link java.util.regex.Pattern}.{@link
     * java.util.regex.Pattern#matches(String,CharSequence)
     * matches}(</tt><i>regex</i><tt>,</tt> <i>str</i><tt>)</tt></blockquote>
     *
     * @param   regex
     *          the regular expression to which this string is to be matched
     *
     * @return boolean <tt>true</tt> if, and only if, this string matches the
     *          given regular expression
     *
     * @throws  PatternSyntaxException
     *          if the regular expression's syntax is invalid
     *
     * @see java.util.regex.Pattern
     *
     * @since 1.4
     * @spec JSR-51
     */
    public function matches($regex) {
        $regex = String::asNative($regex);
        return preg_match($regex, $this->string) != 0;
//        return Pattern.matches(regex, this);
    }

    /**
     * Returns true if and only if this string contains the specified
     * sequence of char values.
     *
     * @param s the sequence to search for
     * @return boolean true if this string contains <code>s</code>, false otherwise
     * @throws NullPointerException if <code>s</code> is <code>null</code>
     * @since 1.5
     */
    public function contains($s) {
        $str = String::asNative($s);
        return $this->indexOf($str) > -1;
    }

    /**
     * Replaces the first substring of this string that matches the given <a
     * href="../util/regex/Pattern.html#sum">regular expression</a> with the
     * given replacement.
     *
     * <p> An invocation of this method of the form
     * <i>str</i><tt>.replaceFirst(</tt><i>regex</i><tt>,</tt> <i>repl</i><tt>)</tt>
     * yields exactly the same result as the expression
     *
     * <blockquote><tt>
     * {@link java.util.regex.Pattern}.{@link java.util.regex.Pattern#compile
     * compile}(</tt><i>regex</i><tt>).{@link
     * java.util.regex.Pattern#matcher(java.lang.CharSequence)
     * matcher}(</tt><i>str</i><tt>).{@link java.util.regex.Matcher#replaceFirst
     * replaceFirst}(</tt><i>repl</i><tt>)</tt></blockquote>
     *
     *<p>
     * Note that backslashes (<tt>\</tt>) and dollar signs (<tt>$</tt>) in the
     * replacement string may cause the results to be different than if it were
     * being treated as a literal replacement string; see
     * {@link java.util.regex.Matcher#replaceFirst}.
     * Use {@link java.util.regex.Matcher#quoteReplacement} to suppress the special
     * meaning of these characters, if desired.
     *
     * @param   regex
     *          the regular expression to which this string is to be matched
     * @param   replacement
     *          the string to be substituted for the first match
     *
     * @return  blaze\lang\String The resulting <tt>String</tt>
     *
     * @throws  PatternSyntaxException
     *          if the regular expression's syntax is invalid
     *
     * @see java.util.regex.Pattern
     *
     * @since 1.4
     * @spec JSR-51
     */
    public function replaceRegex($regex, $replacement, $limit = 1) {
        $regex = String::asNative($regex);
        $replacement = String::asNative($replacement);

        return preg_replace($regex, $replacement, $this->string, $limit);
//	return Pattern.compile(regex).matcher(this).replaceFirst(replacement);
    }

    /**
     * Replaces each substring of this string that matches the given <a
     * href="../util/regex/Pattern.html#sum">regular expression</a> with the
     * given replacement.
     *
     * <p> An invocation of this method of the form
     * <i>str</i><tt>.replaceAll(</tt><i>regex</i><tt>,</tt> <i>repl</i><tt>)</tt>
     * yields exactly the same result as the expression
     *
     * <blockquote><tt>
     * {@link java.util.regex.Pattern}.{@link java.util.regex.Pattern#compile
     * compile}(</tt><i>regex</i><tt>).{@link
     * java.util.regex.Pattern#matcher(java.lang.CharSequence)
     * matcher}(</tt><i>str</i><tt>).{@link java.util.regex.Matcher#replaceAll
     * replaceAll}(</tt><i>repl</i><tt>)</tt></blockquote>
     *
     *<p>
     * Note that backslashes (<tt>\</tt>) and dollar signs (<tt>$</tt>) in the
     * replacement string may cause the results to be different than if it were
     * being treated as a literal replacement string; see
     * {@link java.util.regex.Matcher#replaceAll Matcher.replaceAll}.
     * Use {@link java.util.regex.Matcher#quoteReplacement} to suppress the special
     * meaning of these characters, if desired.
     *
     * @param   regex
     *          the regular expression to which this string is to be matched
     * @param   replacement
     *          the string to be substituted for each match
     *
     * @return  blaze\lang\String The resulting <tt>String</tt>
     *
     * @throws  PatternSyntaxException
     *          if the regular expression's syntax is invalid
     *
     * @see java.util.regex.Pattern
     *
     * @since 1.4
     * @spec JSR-51
     */
    public function replaceAll($regex, $replacement) {
        $regex = String::asNative($regex);
        $replacement = String::asNative($replacement);

        return new String(preg_replace($regex, $replacement, $this->string));
//	return Pattern.compile(regex).matcher(this).replaceAll(replacement);
    }

    /**
     * Splits this string around matches of the given <a
     * href="../util/regex/Pattern.html#sum">regular expression</a>.
     *
     * <p> This method works as if by invoking the two-argument {@link
     * #split(String, int) split} method with the given expression and a limit
     * argument of zero.  Trailing empty strings are therefore not included in
     * the resulting array.
     *
     * <p> The string <tt>"boo:and:foo"</tt>, for example, yields the following
     * results with these expressions:
     *
     * <blockquote><table cellpadding=1 cellspacing=0 summary="Split examples showing regex and result">
     * <tr>
     *  <th>Regex</th>
     *  <th>Result</th>
     * </tr>
     * <tr><td align=center>:</td>
     *     <td><tt>{ "boo", "and", "foo" }</tt></td></tr>
     * <tr><td align=center>o</td>
     *     <td><tt>{ "b", "", ":and:f" }</tt></td></tr>
     * </table></blockquote>
     *
     *
     * @param  regex
     *         the delimiting regular expression
     *
     * @return array[blaze\lang\String] the array of strings computed by splitting this string
     *          around matches of the given regular expression
     *
     * @throws  PatternSyntaxException
     *          if the regular expression's syntax is invalid
     *
     * @see java.util.regex.Pattern
     *
     * @since 1.4
     * @spec JSR-51
     */
    public function split($delimiter, $limit = null, $wrapper = false) {
        $delimiter = String::asNative($delimiter);
        if($limit != null)
            $pieces = explode($delimiter, $this->string, $limit);
        else
            $pieces = explode($delimiter, $this->string);

        if(!$wrapper)
            return $pieces;
        $result = array();

        foreach($pieces as $piece)
            $result[] = new String($piece);
        return $result;
    }

    /**
     * Splits this string around matches of the given <a
     * href="../util/regex/Pattern.html#sum">regular expression</a>.
     *
     * <p> This method works as if by invoking the two-argument {@link
     * #split(String, int) split} method with the given expression and a limit
     * argument of zero.  Trailing empty strings are therefore not included in
     * the resulting array.
     *
     * <p> The string <tt>"boo:and:foo"</tt>, for example, yields the following
     * results with these expressions:
     *
     * <blockquote><table cellpadding=1 cellspacing=0 summary="Split examples showing regex and result">
     * <tr>
     *  <th>Regex</th>
     *  <th>Result</th>
     * </tr>
     * <tr><td align=center>:</td>
     *     <td><tt>{ "boo", "and", "foo" }</tt></td></tr>
     * <tr><td align=center>o</td>
     *     <td><tt>{ "b", "", ":and:f" }</tt></td></tr>
     * </table></blockquote>
     *
     *
     * @param  regex
     *         the delimiting regular expression
     *
     * @return array[blaze\lang\String] the array of strings computed by splitting this string
     *          around matches of the given regular expression
     *
     * @throws  PatternSyntaxException
     *          if the regular expression's syntax is invalid
     *
     * @see java.util.regex.Pattern
     *
     * @since 1.4
     * @spec JSR-51
     */
    public function splitRegex($regex, $limit = null, $wrapper = false) {
        $regex = String::asNative($regex);
        if(!$wrapper)
            return preg_split($regex, $this->string, $limit);
        $pieces = preg_split($regex, $this->string, $limit);
        $result = array();

        foreach($pieces as $piece)
            $result[] = new String($piece);
        return $result;
    }

    /**
     * Converts all of the characters in this <code>String</code> to lower
     * case using the rules of the given <code>Locale</code>.  Case mapping is based
     * on the Unicode Standard version specified by the {@link java.lang.Character Character}
     * class. Since case mappings are not always 1:1 char mappings, the resulting
     * <code>String</code> may be a different length than the original <code>String</code>.
     * <p>
     * Examples of lowercase  mappings are in the following table:
     * <table border="1" summary="Lowercase mapping examples showing language code of locale, upper case, lower case, and description">
     * <tr>
     *   <th>Language Code of Locale</th>
     *   <th>Upper Case</th>
     *   <th>Lower Case</th>
     *   <th>Description</th>
     * </tr>
     * <tr>
     *   <td>tr (Turkish)</td>
     *   <td>&#92;u0130</td>
     *   <td>&#92;u0069</td>
     *   <td>capital letter I with dot above -&gt; small letter i</td>
     * </tr>
     * <tr>
     *   <td>tr (Turkish)</td>
     *   <td>&#92;u0049</td>
     *   <td>&#92;u0131</td>
     *   <td>capital letter I -&gt; small letter dotless i </td>
     * </tr>
     * <tr>
     *   <td>(all)</td>
     *   <td>French Fries</td>
     *   <td>french fries</td>
     *   <td>lowercased all chars in String</td>
     * </tr>
     * <tr>
     *   <td>(all)</td>
     *   <td><img src="doc-files/capiota.gif" alt="capiota"><img src="doc-files/capchi.gif" alt="capchi">
     *       <img src="doc-files/captheta.gif" alt="captheta"><img src="doc-files/capupsil.gif" alt="capupsil">
     *       <img src="doc-files/capsigma.gif" alt="capsigma"></td>
     *   <td><img src="doc-files/iota.gif" alt="iota"><img src="doc-files/chi.gif" alt="chi">
     *       <img src="doc-files/theta.gif" alt="theta"><img src="doc-files/upsilon.gif" alt="upsilon">
     *       <img src="doc-files/sigma1.gif" alt="sigma"></td>
     *   <td>lowercased all chars in String</td>
     * </tr>
     * </table>
     *
     * @param locale use the case transformation rules for this locale
     * @return  blaze\lang\String the <code>String</code>, converted to lowercase.
     * @see     java.lang.String#toLowerCase()
     * @see     java.lang.String#toUpperCase()
     * @see     java.lang.String#toUpperCase(Locale)
     * @since   1.1
     */
    public function toLowerCase($first = false, Locale $locale = null) {
        if($first)
            return new String(lcfirst($this->string));
        return new String(strtolower($this->string));
//	if (locale == null) {
//	    throw new NullPointerException();
//        }
//
//        int     firstUpper;
//
//	/* Now check if there are any characters that need to be changed. */
//	scan: {
//	    for (firstUpper = 0 ; firstUpper < count; ) {
//		char c = value[offset+firstUpper];
//		if ((c >= Character.MIN_HIGH_SURROGATE) &&
//		    (c <= Character.MAX_HIGH_SURROGATE)) {
//		    int supplChar = codePointAt(firstUpper);
//		    if (supplChar != Character.toLowerCase(supplChar)) {
//		        break scan;
//		    }
//		    firstUpper += Character.charCount(supplChar);
//		} else {
//		    if (c != Character.toLowerCase(c)) {
//		        break scan;
//		    }
//		    firstUpper++;
//		}
//	    }
//	    return this;
//	}
//
//        char[]  result = new char[count];
//	int     resultOffset = 0;  /* result may grow, so i+resultOffset
//				    * is the write location in result */
//
//        /* Just copy the first few lowerCase characters. */
//        System.arraycopy(value, offset, result, 0, firstUpper);
//
//	String lang = locale.getLanguage();
//	boolean localeDependent =
//            (lang == "tr" || lang == "az" || lang == "lt");
//        char[] lowerCharArray;
//        int lowerChar;
//        int srcChar;
//        int srcCount;
//        for (int i = firstUpper; i < count; i += srcCount) {
//	    srcChar = (int)value[offset+i];
//	    if ((char)srcChar >= Character.MIN_HIGH_SURROGATE &&
//	        (char)srcChar <= Character.MAX_HIGH_SURROGATE) {
//		srcChar = codePointAt(i);
//		srcCount = Character.charCount(srcChar);
//	    } else {
//	        srcCount = 1;
//	    }
//            if (localeDependent || srcChar == '\u03A3') { // GREEK CAPITAL LETTER SIGMA
//                lowerChar = ConditionalSpecialCasing.toLowerCaseEx(this, i, locale);
//            } else {
//                lowerChar = Character.toLowerCase(srcChar);
//            }
//            if ((lowerChar == Character.ERROR) ||
//                (lowerChar >= Character.MIN_SUPPLEMENTARY_CODE_POINT)) {
//                if (lowerChar == Character.ERROR) {
//                    lowerCharArray =
//                        ConditionalSpecialCasing.toLowerCaseCharArray(this, i, locale);
//                } else if (srcCount == 2) {
//		    resultOffset += Character.toChars(lowerChar, result, i + resultOffset) - srcCount;
//		    continue;
//                } else {
//		    lowerCharArray = Character.toChars(lowerChar);
//		}
//
//                /* Grow result if needed */
//                int mapLen = lowerCharArray.length;
//		if (mapLen > srcCount) {
//                    char[] result2 = new char[result.length + mapLen - srcCount];
//                    System.arraycopy(result, 0, result2, 0,
//                        i + resultOffset);
//                    result = result2;
//		}
//                for (int x=0; x<mapLen; ++x) {
//                    result[i+resultOffset+x] = lowerCharArray[x];
//                }
//                resultOffset += (mapLen - srcCount);
//            } else {
//                result[i+resultOffset] = (char)lowerChar;
//            }
//        }
//        return new String(0, count+resultOffset, result);
    }

    /**
     * Converts all of the characters in this <code>String</code> to lower
     * case using the rules of the default locale. This is equivalent to calling
     * <code>toLowerCase(Locale.getDefault())</code>.
     * <p>
     * <b>Note:</b> This method is locale sensitive, and may produce unexpected
     * results if used for strings that are intended to be interpreted locale
     * independently.
     * Examples are programming language identifiers, protocol keys, and HTML
     * tags.
     * For instance, <code>"TITLE".toLowerCase()</code> in a Turkish locale
     * returns <code>"t\u0131tle"</code>, where '\u0131' is the LATIN SMALL
     * LETTER DOTLESS I character.
     * To obtain correct results for locale insensitive strings, use
     * <code>toLowerCase(Locale.ENGLISH)</code>.
     * <p>
     * @return blaze\lang\String the <code>String</code>, converted to lowercase.
     * @see     java.lang.String#toLowerCase(Locale)
     */
//    public function toLowerCase() {
//        return toLowerCase(Locale.getDefault());
//    }

    /**
     * Converts all of the characters in this <code>String</code> to upper
     * case using the rules of the given <code>Locale</code>. Case mapping is based
     * on the Unicode Standard version specified by the {@link java.lang.Character Character}
     * class. Since case mappings are not always 1:1 char mappings, the resulting
     * <code>String</code> may be a different length than the original <code>String</code>.
     * <p>
     * Examples of locale-sensitive and 1:M case mappings are in the following table.
     * <p>
     * <table border="1" summary="Examples of locale-sensitive and 1:M case mappings. Shows Language code of locale, lower case, upper case, and description.">
     * <tr>
     *   <th>Language Code of Locale</th>
     *   <th>Lower Case</th>
     *   <th>Upper Case</th>
     *   <th>Description</th>
     * </tr>
     * <tr>
     *   <td>tr (Turkish)</td>
     *   <td>&#92;u0069</td>
     *   <td>&#92;u0130</td>
     *   <td>small letter i -&gt; capital letter I with dot above</td>
     * </tr>
     * <tr>
     *   <td>tr (Turkish)</td>
     *   <td>&#92;u0131</td>
     *   <td>&#92;u0049</td>
     *   <td>small letter dotless i -&gt; capital letter I</td>
     * </tr>
     * <tr>
     *   <td>(all)</td>
     *   <td>&#92;u00df</td>
     *   <td>&#92;u0053 &#92;u0053</td>
     *   <td>small letter sharp s -&gt; two letters: SS</td>
     * </tr>
     * <tr>
     *   <td>(all)</td>
     *   <td>Fahrvergn&uuml;gen</td>
     *   <td>FAHRVERGN&Uuml;GEN</td>
     *   <td></td>
     * </tr>
     * </table>
     * @param locale use the case transformation rules for this locale
     * @return blaze\lang\String the <code>String</code>, converted to uppercase.
     * @see     java.lang.String#toUpperCase()
     * @see     java.lang.String#toLowerCase()
     * @see     java.lang.String#toLowerCase(Locale)
     * @since   1.1
     */
    public function toUpperCase($first = false, Locale $locale = null) {
        if($first)
            return new String(ucfirst($this->string));
        return new String(strtoupper($this->string));
//	if (locale == null) {
//	    throw new NullPointerException();
//        }
//
//        int     firstLower;
//
//	/* Now check if there are any characters that need to be changed. */
//	scan: {
//	    for (firstLower = 0 ; firstLower < count; ) {
//		int c = (int)value[offset+firstLower];
//		int srcCount;
//		if ((c >= Character.MIN_HIGH_SURROGATE) &&
//		    (c <= Character.MAX_HIGH_SURROGATE)) {
//		    c = codePointAt(firstLower);
//		    srcCount = Character.charCount(c);
//		} else {
//		    srcCount = 1;
//		}
//		int upperCaseChar = Character.toUpperCaseEx(c);
//		if ((upperCaseChar == Character.ERROR) ||
//		    (c != upperCaseChar)) {
//		    break scan;
//		}
//		firstLower += srcCount;
//	    }
//	    return this;
//	}
//
//        char[]  result       = new char[count]; /* may grow */
//	int     resultOffset = 0;  /* result may grow, so i+resultOffset
//				    * is the write location in result */
//
//	/* Just copy the first few upperCase characters. */
//	System.arraycopy(value, offset, result, 0, firstLower);
//
//	String lang = locale.getLanguage();
//	boolean localeDependent =
//            (lang == "tr" || lang == "az" || lang == "lt");
//        char[] upperCharArray;
//        int upperChar;
//        int srcChar;
//        int srcCount;
//        for (int i = firstLower; i < count; i += srcCount) {
//	    srcChar = (int)value[offset+i];
//	    if ((char)srcChar >= Character.MIN_HIGH_SURROGATE &&
//	        (char)srcChar <= Character.MAX_HIGH_SURROGATE) {
//		srcChar = codePointAt(i);
//		srcCount = Character.charCount(srcChar);
//	    } else {
//	        srcCount = 1;
//	    }
//            if (localeDependent) {
//                upperChar = ConditionalSpecialCasing.toUpperCaseEx(this, i, locale);
//            } else {
//                upperChar = Character.toUpperCaseEx(srcChar);
//            }
//            if ((upperChar == Character.ERROR) ||
//                (upperChar >= Character.MIN_SUPPLEMENTARY_CODE_POINT)) {
//                if (upperChar == Character.ERROR) {
//                    if (localeDependent) {
//                        upperCharArray =
//                            ConditionalSpecialCasing.toUpperCaseCharArray(this, i, locale);
//                    } else {
//                        upperCharArray = Character.toUpperCaseCharArray(srcChar);
//                    }
//                } else if (srcCount == 2) {
//		    resultOffset += Character.toChars(upperChar, result, i + resultOffset) - srcCount;
//		    continue;
//                } else {
//                    upperCharArray = Character.toChars(upperChar);
//		}
//
//                /* Grow result if needed */
//                int mapLen = upperCharArray.length;
//		if (mapLen > srcCount) {
//                    char[] result2 = new char[result.length + mapLen - srcCount];
//                    System.arraycopy(result, 0, result2, 0,
//                        i + resultOffset);
//                    result = result2;
//		}
//                for (int x=0; x<mapLen; ++x) {
//                    result[i+resultOffset+x] = upperCharArray[x];
//                }
//                resultOffset += (mapLen - srcCount);
//            } else {
//                result[i+resultOffset] = (char)upperChar;
//            }
//        }
//        return new String(0, count+resultOffset, result);
    }

    /**
     * Converts all of the characters in this <code>String</code> to upper
     * case using the rules of the default locale. This method is equivalent to
     * <code>toUpperCase(Locale.getDefault())</code>.
     * <p>
     * <b>Note:</b> This method is locale sensitive, and may produce unexpected
     * results if used for strings that are intended to be interpreted locale
     * independently.
     * Examples are programming language identifiers, protocol keys, and HTML
     * tags.
     * For instance, <code>"title".toUpperCase()</code> in a Turkish locale
     * returns <code>"T\u0130TLE"</code>, where '\u0130' is the LATIN CAPITAL
     * LETTER I WITH DOT ABOVE character.
     * To obtain correct results for locale insensitive strings, use
     * <code>toUpperCase(Locale.ENGLISH)</code>.
     * <p>
     * @return blaze\lang\String the <code>String</code>, converted to uppercase.
     * @see     java.lang.String#toUpperCase(Locale)
     */
//    public function toUpperCase() {
//        return toUpperCase(Locale.getDefault());
//    }

    /**
     * Returns a copy of the string, with leading and trailing whitespace
     * omitted.
     * <p>
     * If this <code>String</code> object represents an empty character
     * sequence, or the first and last characters of character sequence
     * represented by this <code>String</code> object both have codes
     * greater than <code>'&#92;u0020'</code> (the space character), then a
     * reference to this <code>String</code> object is returned.
     * <p>
     * Otherwise, if there is no character with a code greater than
     * <code>'&#92;u0020'</code> in the string, then a new
     * <code>String</code> object representing an empty string is created
     * and returned.
     * <p>
     * Otherwise, let <i>k</i> be the index of the first character in the
     * string whose code is greater than <code>'&#92;u0020'</code>, and let
     * <i>m</i> be the index of the last character in the string whose code
     * is greater than <code>'&#92;u0020'</code>. A new <code>String</code>
     * object is created, representing the substring of this string that
     * begins with the character at index <i>k</i> and ends with the
     * character at index <i>m</i>-that is, the result of
     * <code>this.substring(<i>k</i>,&nbsp;<i>m</i>+1)</code>.
     * <p>
     * This method may be used to trim whitespace (as defined above) from
     * the beginning and end of a string.
     *
     * @return blaze\lang\String A copy of this string with leading and trailing white
     *          space removed, or this string if it has no leading or
     *          trailing white space.
     */
    public function trim($charlist = null) {
        return new String(trim($this->string, $charlist));
    }


    /**
     * Returns a formatted string using the specified locale, format string,
     * and arguments.
     *
     * @param  l
     *         The {@linkplain java.util.Locale locale} to apply during
     *         formatting.  If <tt>l</tt> is <tt>null</tt> then no localization
     *         is applied.
     *
     * @param blaze\lang\String|string $format
     *         A <a href="../util/Formatter.html#syntax">format string</a>
     *
     * @param array[blaze\lang\Object] args
     *         Arguments referenced by the format specifiers in the format
     *         string.  If there are more arguments than format specifiers, the
     *         extra arguments are ignored.  The number of arguments is
     *         variable and may be zero.  The maximum number of arguments is
     *         limited by the maximum dimension of a Java array as defined by
     *         the <a href="http://java.sun.com/docs/books/vmspec/">Java
     *         Virtual Machine Specification</a>.  The behaviour on a
     *         <tt>null</tt> argument depends on the <a
     *         href="../util/Formatter.html#syntax">conversion</a>.
     *
     * @throws  IllegalFormatException
     *          If a format string contains an illegal syntax, a format
     *          specifier that is incompatible with the given arguments,
     *          insufficient arguments given the format string, or other
     *          illegal conditions.  For specification of all possible
     *          formatting errors, see the <a
     *          href="../util/Formatter.html#detail">Details</a> section of the
     *          formatter class specification
     *
     * @throws  NullPointerException
     *          If the <tt>format</tt> is <tt>null</tt>
     *
     * @return blaze\lang\String A formatted string
     *
     * @see  java.util.Formatter
     * @since  1.5
     */
    public static function format($format, $args, Locale $l = null) {
        $f = new Formatter($l);
	return $f->format($format, $args)->toString();
    }

    /**
     * Returns the string representation of the <code>double</code> argument.
     * <p>
     * The representation is exactly the one returned by the
     * <code>Double.toString</code> method of one argument.
     *
     * @param   d   a <code>double</code>.
     * @return blaze\lang\String a  string representation of the <code>double</code> argument.
     * @see     java.lang.Double#toString(double)
     */
    public static function valueOf($value) {
        if($value === null){
            return 'null';
        }else if(is_object($value) && $value instanceof Object){
            return $value->__toString();
        }else if(is_bool($value)){
            return $value ? 'true' : 'false';
        }else if(is_float($value)){
            return Float::toString($value);
        }else if(is_double($value)){
            return Double::toString($value);
        }else if(is_int($value)){
            return Integer::toString($value);
        }else if(is_string($value)){
            return $value;
        }else{
            throw new IllegalArgumentException($value);
        }
    }

}
?>
