<?php
namespace blaze\io;

/**
 * A writable object is ressource in which can be written.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
interface Writable {
    /**
     * Writes the value of $str into the underlying ressource.
     * With $off you can define a start point in $str and $len specifies the number of chars you want to
     * write.
     *
     * @param 	blaze\lang\String|string $str The value you want to write
     * @param 	integer $off The start offset in the data
     * @param 	integer $len The number of chars to write, if this value is -1 then $str is written from $off to the end of $str
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function write($str, $off = 0, $len = -1);
}

?>
