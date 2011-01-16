<?php

namespace blaze\cache;

/**
 * Support for pluggable caches.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     \blaze\cache\Cache
 * @since   1.0
 * @author Christian Beikov
 */
interface CacheProvider {

    /**
     * Configure the cache
     *
     * @param \blaze\collections\map\Properties $properties The configuration settings
     * @return Cache The object for caching
     * @throws \blaze\cache\CacheException When an error occurs while creating the cache object
     */
    public function buildCache(\blaze\collections\map\Properties $properties);
}

?>
