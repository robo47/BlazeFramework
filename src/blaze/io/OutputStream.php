<?php
namespace blaze\io;
use blaze\lang\Object;

/**
 * This is the abstract superclass for all output streams. Since there is no
 * native datatyp byte in PHP, this class supports writing for strings.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\io\InputStream
 * @since   1.0
 * @version $Revision$
 */
abstract class OutputStream extends Object implements Closeable, Flushable, Writable {


    protected function checkClosed(){
        if($this->isClosed())
                throw new IOException($this->toString().' is already closed.');
    }
}

?>
