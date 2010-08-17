<?php
namespace blaze\io;
use blaze\lang\StringBuffer;
/**
 * Description of Readable
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
interface Readable {
    /**
     * Reads contents of a ressource and returns $len characters as string or the content until EOF if no $len was given.
     *
     * @param 	int $len The maximum number of chars to be read
     * @return 	string If no $len was defined or the current position + $len is beyond EOF, it returns all the content until EOF.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function read($len = -1);
    /**
     * Reads $len characters of a ressource into the buffer at the given offset or the content until EOF if no $len was given.
     *
     * @param 	blaze\lang\StringBuffer $buffer The buffer in which the chars shall be read into
     * @param 	int $off The startpoint of the buffer to start storing
     * @param 	int $len The maximum number of chars to be read
     * @return 	int Returns the number of chars which were read into it, or -1 if nothing could be read.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function readInto(StringBuffer $buffer, $off = -1, $len = -1);
}

?>
