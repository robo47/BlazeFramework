<?php

namespace blaze\io\output;

use blaze\lang\Object;

/**
 * Description of OutputStreamWriter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
class FileWriter extends \blaze\io\OutputStreamWriter {

    /**
     *
     * @param string|blaze\lang\String|blaze\io\File|blaze\io\output\FileOutputStream $fileOrStream
     */
    public function __construct($fileOrStream, $append = false) {
        $stream = null;
        if ($fileOrStream instanceof FileOutputStream)
            $stream = $fileOrStream;
        else if ($fileOrStream instanceof \blaze\io\File || \blaze\lang\String::isType($fileOrStream))
            $stream = new FileOutputStream($fileOrStream, $append, false);
        else
            throw new \blaze\lang\IllegalArgumentException('Invalid argument type for $fileOrStream.');
        parent::__construct($stream);
    }

}

?>
