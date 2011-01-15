<?php

namespace blaze\io;

use blaze\lang\Object;

/**
 * This is the abstract superclass for all string writers. Writer can handle at
 * least string values.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     blaze\io\Reader
 * @since   1.0

 */
abstract class Writer extends Object implements Closeable, Flushable, Writable {

}

?>
