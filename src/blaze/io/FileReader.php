<?php
namespace blaze\io;
use blaze\lang\Object;

/**
 * Description of FileReader
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @version $Revision$
 */
class FileReader extends InputStreamReader {

    /**
     *
     * @param string|blaze\lang\String|blaze\io\File|blaze\io\FileInputStream $fileOrStream
     */
    public function __construct($fileOrStream, $append = false){
        $stream = null;
        if($fileOrStream instanceof FileInputStream)
            $stream = $fileOrStream;
        else if($fileOrStream instanceof File || \blaze\lang\String::isType($fileOrStream))
            $stream = new FileInputStream($fileOrStream, false);
        else
            throw new \blaze\lang\IllegalArgumentException('Invalid argument type for $fileOrStream.');
        parent::__construct($stream);
    }

}

?>
