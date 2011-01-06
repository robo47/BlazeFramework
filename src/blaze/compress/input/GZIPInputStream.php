<?php

namespace blaze\compress\input;

use blaze\lang\Object;

/**
 * GZIPInputStream uses the zlib for reading gzipped stream contents.
 * Due to the native implementation it can also read deeflated stream contents
 * but should not be used for this.
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 */
class GZIPInputStream extends DeflaterInputStream {


}
?>
