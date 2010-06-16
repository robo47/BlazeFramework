<?php
namespace blaze\io;

/**
 * Description of Readable
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
interface Readable {
    /**
     * Reads contents of a ressource into the buffer or if no buffer is given,
     * returns one char as integer.
     *
     * @param 	blaze\lang\StringBuffer $buffer The buffer in which the chars shall be read into
     * @param 	integer $off The startpoint of the buffer to start storing
     * @param 	integer $len The maximum number of chars to be read
     * @return 	integer If no buffer is given, it returns a char represented as integer, or -1 if nothing could be read.
     *                  If a buffer is given, if returns the number of chars which were read into it, or -1 if nothing could be read.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function read(StringBuffer $buffer = null, $off = 0, $len = -1);
}

?>
