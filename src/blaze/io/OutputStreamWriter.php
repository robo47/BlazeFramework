<?php
namespace blaze\io;
use blaze\lang\Object;

/**
 * Description of OutputStreamWriter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class OutputStreamWriter extends Writer {
    public function __construct(OutputStream $os) {
        parent::__construct($os);
    }

}

?>
