<?php
namespace blaze\io;
use blaze\lang\Object;

/**
 * Description of InputStream
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\io\OutputStream
 * @since   1.0
 * @version $Revision$
 */
abstract class InputStream extends Object implements Readable, Closeable {

    /**
     * Returns the number of chars which can be read from the stream.
     *
     * @return 	integer The number of chars which are available for read.
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function available();

    /**
     * Tries to skip over $n chars and returns the number of chars which were skipped over.
     *
     * @param   long $n The number of chars which shall be skipped
     * @return 	long The number of chars which were skipped
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
     public function skip($n);
}

?>
