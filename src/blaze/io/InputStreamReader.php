<?php
namespace blaze\io;
use blaze\lang\Object;

/**
 * Description of InputStreamReader
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class InputStreamReader extends Reader {
    public function __construct(InputStream $is){
        parent::__construct($is);
    }
}

?>
