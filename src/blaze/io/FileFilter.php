<?php
namespace blaze\io;

/**
 * DataInput
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL

 * @since   1.0

 */
interface FileFilter {
    /**
     * @return boolean
     */
    public function accept(File $file);
}

?>
