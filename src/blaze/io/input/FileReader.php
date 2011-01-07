<?php

namespace blaze\io\input;

use blaze\lang\Object;

/**
 * Description of FileReader
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
class FileReader extends \blaze\io\InputStreamReader {

    /**
     *
     * @param string|blaze\lang\String|blaze\io\File|blaze\io\input\FileInputStream $fileOrStream
     */
    public function __construct($fileOrStream, $append = false) {
        $stream = null;
        if ($fileOrStream instanceof FileInputStream)
            $stream = $fileOrStream;
        else if ($fileOrStream instanceof \blaze\io\File || \blaze\lang\String::isType($fileOrStream))
            $stream = new FileInputStream($fileOrStream, false);
        else
            throw new \blaze\lang\IllegalArgumentException('Invalid argument type for $fileOrStream.');
        parent::__construct($stream);
    }

}

?>
