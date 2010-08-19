<?php
namespace blaze\io\output;
use blaze\lang\Object,
    blaze\lang\StringBuffer;

/**
 * Description of ByteArrayInputStream
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class FileOutputStream extends NativeOutputStream {
    /**
     * @var \blaze\io\File The associated file.
     */
    protected $file;

    /**
     * Construct a new FileInputStream.
     * @param string|blaze\lang\String|blaze\io\File $file
     * @throws blaze\lang\IllegalArgumentException If invalid argument specified.
     * @throws blaze\io\IOException If any IO error occurs
     */
    public function __construct($file, $append = false, $binary = true) {
        if ($file instanceof \blaze\io\File) {
            $this->file = $file;
        } elseif (\blaze\lang\String::isType($file)) {
            $this->file = new \blaze\io\File($file);
        } else {
            throw new \blaze\lang\IllegalArgumentException('Invalid argument type for $file.');
        }

        parent::__construct($this->file->getAbsolutePath()->toNative(), $append, $binary);
    }

    /**
     * Returns a string representation of the attached file.
     * @return string
     */
    public function toString() {
        return $this->file->getPath();
    }


}

?>
