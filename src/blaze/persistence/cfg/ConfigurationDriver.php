<?php
namespace blaze\persistence\cfg;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
interface ConfigurationDriver {
    /**
     * @param string|blaze\lang\String $content
     * @param string|blaze\lang\String|blaze\io\File $basePath
     */
    public function parse(\blaze\persistence\cfg\Configuration $config, $content, $basePath = null);
    /**
     * @param string|blaze\lang\String|blaze\io\File $file
     */
    public function parseFile(\blaze\persistence\cfg\Configuration $config, $file);
    /**
     * @param string|blaze\lang\String|blaze\io\File $file
     * @param \blaze\persistence\cfg\Configuration $config
     */
    public function save(\blaze\persistence\cfg\Configuration $config, $file);
}

?>
