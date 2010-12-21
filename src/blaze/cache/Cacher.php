<?php
namespace blaze\cache;

/**
 * Cacher implementations are responsible for managing objects in their
 * specified sources. A cacher should be only used with a CacheManager to
 * guarantee security related checks and to be able to use hirachic caching.
 *
 * How to use the Cacher:
 *
 * $cacher = LocalCacher::getInstance();
 * $cacheMgr = CacheManager::getInstance('testApplication', $cacher);
 *
 * $cacheMgr->doCache('userid_1', 'John Doe');
 * $cacheMgr->doCache('userid_2', 'Jane Doe');
 * $cacheMgr->doCache('userid_3', 'Anybody');
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     \blaze\cache\CacheManager
 * @since   1.0
 * @author Christian Beikov
 */
interface Cacher {
    /**
     * This method is responsible for caching the specified value, mapped to the
     * key. It has to be guaranteed that the cache is locked for that moment
     * to provide a consistent status. The method has to return wether the caching
     * action was successfull or not. The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key to which the value should be mapped
     * @param mixed|blaze\lang\Object $value The value which should be cached
     * @return boolean True if the caching action was successfull, otherwise false
     */
    public function doCache($key, $value);
    /**
     * This method checks wether the key exists in the cache or not, it is
     * not responsible to check for null.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     */
    public function isCached($key);
    /**
     * This method locks the cache to get a consistent value and returns it. If
     * the key is not available in the cache, a CacheNotFoundException is thrown.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return mixed|blaze\lang\Object
     * @throws \blaze\cache\CacheNotFoundException Is thrown when the key is not found
     */
    public function getCache($key);
    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries which start with the given keyPrefix are returned as a list.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys that start with keyPrefix, or an empty map
     */
    public function getCacheEntries($keyPrefix);
    /**
     * Locks the cache to consistently invalidate the cache entry with the given key.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean False if the cache entry could not be invalidated, otherwise true
     */
    public function invalidate($key);
    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys start with the given keyPrefix get invalidated.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     */
    public function invalidateAll($keyPrefix);
}
?>
