<?php
namespace blaze\persistence\meta;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface MetaDriver {
    /**
     * @param string|blaze\lang\String $content
     * @return \blaze\persistence\meta\ClassDescriptor
     */
    public function parse($content);
    /**
     * @param string|blaze\lang\String|blaze\io\File $file
     * @return \blaze\persistence\meta\ClassDescriptor
     */
    public function parseFile($file);
    /**
     * @param string|blaze\lang\String|blaze\io\File $file
     * @return \blaze\collections\ListI[\blaze\persistence\meta\ClassDescriptor]
     */
    public function parseDirectory($dir, $recursive = false);
    /**
     * @param string|blaze\lang\String|blaze\io\File $file
     * @param \blaze\persistence\cfg\Configuration $config
     */
    public function save(\blaze\persistence\meta\ClassDescriptor $class, $file);
}

?>
