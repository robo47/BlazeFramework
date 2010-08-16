<?php
namespace blaze\io;
use blaze\lang\Object;

/**
 * Description of Reader
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class Reader extends Object implements Readable, Closeable, Markable{

    /**
     * Reset the current position to the beginning or to the last mark (if supported).
     * @throws	blaze\lang\IOException Is thrown when an IO error occurs or when the underlying ressource is already closed
     */
    public function reset() {}

    /**
     * Returns wether the stream is ready for reading or not
     * @return boolean
     */
    public function ready() {
        return true;
    }

    public function mark() {}

    public function markSupported() {
        return false;
    }
}

?>
