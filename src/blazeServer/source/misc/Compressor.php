<?php
namespace blazeServer\source\misc;
use blaze\lang\Object;

/**
 * Description of Compressor
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Make a filter or listener of this
 */
class Compressor extends Object {

    public function __construct(){

    }

     public function start(){
        ob_start();
     }

     public function end() {
        if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
            header('Content-Encoding: gzip');
            echo gzencode(ob_get_clean(),9);
        }else{
            echo ob_get_clean();
        }

        header("Content-Length: ".ob_get_length());
        ob_end_flush();
    }
}

?>
