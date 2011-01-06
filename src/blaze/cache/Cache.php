<?php

namespace blaze\cache;

/**
 * Cache implementations are responsible for managing objects in their
 * specified sources. A cache should be only used with a CacheManager to
 * guarantee security related checks and to be able to use hirachic caching.
 *
 * How to use the Cache:
 *
 * $cache = LocalCache::getInstance();
 * $cacheMgr = CacheManager::getInstance('testApplication', $cache);
 *
 * $cacheMgr->put('userid_1', 'John Doe');
 * $cacheMgr->put('userid_2', 'Jane Doe');
 * $cacheMgr->put('userid_3', 'Anybody');
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @see     \blaze\cache\CacheManager
 * @since   1.0
 * @author Christian Beikov
 */
interface Cache{
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
    public function put($key, $value);
    /**
     * Puts all entries of the map into the cache in an more efficient way than
     * putting them as single entries with put(key, value) into it.
     *
     * @param \blaze\collections\Map $map The map which contains the entries which should be put into the cache
     * @return boolean true if all entries were put into the cache, otherwise false
     */
    public function putAll(\blaze\collections\Map $map);
    /**
     * This method checks wether the key exists in the cache or not, it is
     * not responsible to check for null.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     */
    public function contains($key);
    /**
     * This method checks wether a key with keyPrefix exists in the cache or not, it is
     * not responsible to check for null.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of the key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     */
    public function containsByPrefix($keyPrefix);
    /**
     * This method checks wether a key with keySuffix exists in the cache or not.
     *
     * @param string|blaze\lang\String $keySuffix The suffix of the key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     */
    public function containsBySuffix($keySuffix);
    /**
     * This method checks wether the regex matches to any key in the cache or not.
     *
     * @param string|blaze\lang\String $regex The regex which a key has to match
     * @return boolean True if an entry in the cache exists, otherwise false
     */
    public function containsByRegex($regex);
    /**
     * Clear the cache
     */
    public function clear();
    /**
     * This method locks the cache to get a consistent value and returns it. If
     * the key is not available in the cache, null is returned.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return mixed|blaze\lang\Object The object or null if nothing was found.
     */
    public function get($key);
    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries which start with the given keyPrefix are returned as a map.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys that start with keyPrefix, or an empty map
     */
    public function getByPrefix($keyPrefix);
    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries which end with the given keySuffix are returned as a map.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $keySuffix The suffix of a key which to look for in the cache
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys that end with keySuffix, or an empty map
     */
    public function getBySuffix($keySuffix);
    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries match the regex are returned as a map.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $regex The regex which a key has to match
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys match the regex, or an empty map
     */
    public function getByRegex($regex);
    /**
     * Locks the cache to consistently invalidate the cache entry with the given key.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean False if the cache entry could not be invalidated, otherwise true
     */
    public function remove($key);
    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys start with the given keyPrefix get invalidated.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     */
    public function removeByPrefix($keyPrefix);
    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys end with the given keySuffix get invalidated.
     *
     * @param string|blaze\lang\String $keySuffix The suffix of a key which to look for in the cache
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     */
    public function removeBySuffix($keySuffix);
    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys match the given regex get invalidated.
     *
     * @param string|blaze\lang\String $regex The regex which a key has to match
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     */
    public function removeByRegex($regex);
}
?>
