<?php
namespace blaze\lang;
use blaze\lang\Object;

/**
 * Description of StringBuffer
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class StringBuffer extends Object {

    /**
     *
     * @var string
     */
    private $string;

    /**
     *
     * @var long
     */
    private $count;

    /**
     * Beschreibung
     */
    public function __construct($str = null){
        if($str != null)
            $this->string = String::asNative($str);
        else
            $this->string = "";
        $this->count = strlen($this->string);
    }

    /**
     * Appends the given $val to the buffer
     *
     * @param 	mixed $val The value which shall be added to the buffer
     * @return  blaze\lang\StringBuffer
     */
     public function append($val){
        $this->string .= $val;
        $this->count = strlen($this->string);
        return $this;
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
     * @throws  IndexOutOfBoundsException  if the <code>index</code>
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
    public function substring($beginIndex, $endIndex = -1) {
        if($endIndex == -1) {
            $endIndex = $this->count;
        }
	if ($beginIndex < 0) {
	    throw new StringIndexOutOfBoundsException(beginIndex);
	}
	if ($endIndex > $this->count) {
	    throw new StringIndexOutOfBoundsException(endIndex);
	}
	if ($beginIndex > $endIndex) {
	    throw new StringIndexOutOfBoundsException(endIndex - beginIndex);
	}
	return (($beginIndex == 0) && ($endIndex == $this->count)) ? $this :
	    new String($this->string, $beginIndex, $endIndex);
    }

    /**
     * Sets the length of the buffer to the given value. If $len is negative an
     * IndexOutOfBoundsException is thrown.
     * 
     * @param int $len
     * @return blaze\lang\StringBuffer
     * @throws blaze\lang\IndexOutOfBoundsException Is thrown when $len is negative
     */
    public function setLength($len){
        if($len < 0)
            throw new IndexOutOfBoundsException($len);
        $this->string = substr($this->string,0,$len);
        $this->count = strlen($this->string);
        return $this;
    }


    /**
     * Sets the value of the buffer at the position $off to the given value.
     * If the size of given string is greater than 1, then every char after the
     * position $off is overwritten.
     * If $off is negative an IndexOutOfBoundsException is thrown.
     *
     * @param blaze\lang\String|string $str
     * @param integer $off
     * @return blaze\lang\StringBuffer
     * @throws blaze\lang\IndexOutOfBoundsException Is thrown when $len is negative
     * @todo Test what happens when $newStart == $this->count, maybe need ($newStart >= $this->count)
     */
    public function setStringAt($str, $off){
        $str = String::asNative($str);
        if($off < 0)
            throw new IndexOutOfBoundsException($off);

        $newStart = $off + strlen($str);
        if($newStart > $this->count)
            $this->string = substr($this->string,0,$off).$str;
        else
            $this->string = substr($this->string,0,$off).$str.substr($this->string,$newStart);

        $this->count = strlen($this->string);
        return $this;
    }

    /**
     *
     * @return blaze\lang\StringBuffer
     */
    public function reverse(){
        $this->string = strrev($this->string);
        return $this;
    }

    public function replace(){
        return $this;
    }
    public function lastIndexOf(){
        return $this;
    }

    /**
     * Inserts the given $val to the buffer
     *
     * @param 	mixed $val The value which shall be inserted into the buffer
     * @param 	integer $off The index of the buffer where $val shall be inserted into.
     * @param 	integer $start The startpoint of $val which shall be inserted into the buffer
     * @param 	integer $end The endpoint of $val which shall be insterted into the buffer
     * @return  blaze\lang\StringBuffer
     */
    public function insert($val, $off, $start, $end){
        return $this;
    }
    public function indexOf(){
        return $this;
    }
    public function delete($start, $end = -1){
        return $this;
    }

    public function __toString(){
        return $this->string;
    }
}

?>
