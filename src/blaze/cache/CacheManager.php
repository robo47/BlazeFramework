<?php
namespace blaze\cache;

/**
 * The CacheManager is used for hierachic cache management and uses the configured
 * security policy for caching. Caching with the CacheManager is the preferred
 * way because every child instance has it's own context for caching.
 *
 * How to use the CacheManager:
 *
 * $cacher = LocalCacher::getInstance();
 * $cacheMgr = CacheManager::getInstance('testApplication', $cacher);
 *
 * $cacheMgr->doCache('userid_1', 'John Doe');
 * $cacheMgr->doCache('userid_2', 'Jane Doe');
 * $cacheMgr->doCache('userid_3', 'Anybody');
 * $subCache = $cacheMgr->getChild('subCache');
 *
 * $subCache->doCache('emailAuthentification', true);
 * $cacheMgr->invalidateAll(); // Invalidates the main cache and the sub cache
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     \blaze\cache\Cacher
 * @since   1.0
 * @author Christian Beikov
 */
final class CacheManager{

    private static $rootInstances = array();
    private $parent;
    private $children = array();
    private $key;
    private $cacher;

    private function __construct($parent, $key, Cacher $cacher) {
        $this->parent = $parent;
        $this->key = $key;
        $this->cacher = $cacher;
    }

    /**
     * Returns a root CacheManager instance for the given key. If a CacheManager
     * for the given key has already been initialized then the cacher parameter
     * is ignored. If no cacher for the given key is available, then a new
     * CacheManager instance is created with the given cacher parameter. If
     * no instance is available for the given key and the cacher is null, null is returned.
     *
     * @param string|blaze\lang\String $key The key to which the CacheManager instance should be mapped
     * @param Cacher $cacher The cacher which should be used for the CacheManager
     * @return blaze\cache\CacheManager returns a CacheManager or null if no entry for the key is available and the parameter cacher is null
     */
    public static function getInstance($key, Cacher $cacher = null){
        $key = \blaze\lang\String::asNative($key);
        
        if(!array_key_exists($key, self::$rootInstances)){
            if($cacher !== null)
                return self::$rootInstances[$key] = new self(null, $key, $cacher);
            else
                return null;
        }else{
            return self::$rootInstances[$key];
        }
    }

    /**
     * Creates a new CacheManager instance which is hierachically under the current one.
     * It returns a mapped child instance if it has already been created.
     *
     * @param string|blaze\lang\String $key The key to which the CacheManager child instance should be mapped
     * @return blaze\cache\CacheManager The CacheManager child instance
     */
    public function getChild($key){
        if(!array_key_exists($key, $this->children))
            $this->children[$key] = new self($this, $this->key.'.'.$key, $this->cacher);
        return $this->children[$key];
    }

    /**
     * Caches the given value into the cache with the instance key concatenated with the given key as new key.
     *
     * @param string|blaze\lang\String $key The key to which the value should be mapped
     * @param mixed|blaze\lang\Object $value The value which should be cached
     * @return boolean True if the caching action was successfull, otherwise false
     */
    public function doCache($key, $value){
        $this->cacher->doCache($this->key.'.'.$key, $value);
    }

    /**
     * This method checks wether the key exists in the cache or not, it is
     * not responsible to check for null.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     */
    public function isCached($key){
        return $this->cacher->isCached($this->key.'.'.$key);
    }

    /**
     * This method locks the cache to get a consistent value and returns it. If
     * the key is not available in the cache, a CacheNotFoundException is thrown.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return mixed|blaze\lang\Object
     * @throws \blaze\cache\CacheNotFoundException Is thrown when the key is not found
     */
    public function getCache($key){
        return $this->cacher->getCache($this->key.'.'.$key);
    }

    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries which start with the given keyPrefix are returned as a list.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys that start with keyPrefix, or an empty map
     */
    public function getCacheEntries($keyPrefix){
        return $this->cacher->getCacheEntries($this->key.'.'.$keyPrefix);
    }

    /**
     * Locks the cache to consistently invalidate the cache entry with the given key.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean False if the cache entry could not be invalidated, otherwise true
     */
    public function invalidate($key){
        $this->cacher->invalidate($this->key.'.'.$key);
    }

    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys start with the CacheManager key get invalidated.
     *
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     */
    public function invalidateAll(){
        $this->cacher->invalidateAll($this->key);
    }
}
?>
