<?php
namespace blaze\cache;

/**
 * The provider for caching on the hard disk.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @author Christian Beikov
 */
class LocalCacheProvider implements CacheProvider {

    /**
     * {@inheritDoc}
     */
    public function buildCache(\blaze\collections\map\Properties $properties = null){
        if($properties === null)
            return new LocalCache(null);
        else
            return new LocalCache($properties->get('cacheDir'));
    }
}
?>
