<?php
namespace blaze\cache;

/**
 * The CacheManager is used for hierachical cache management and uses the configured
 * security policy for caching. Caching with the CacheManager is the preferred
 * way because every child instance has it's own context for caching. The CacheManager
 * also guarantees that only valid keys are used. Keys have always to be strings
 * and need at least one char.
 *
 * How to use the CacheManager:
 *
 * $cacheProvider = new LocalCacheProvider();
 * $props = new Properties();
 * $props->put('cacheDir', '/tmp');
 * $cache = $cacheProvider->buildCache($props):
 * $cacheMgr = CacheManager::getInstance('testApplication', $cache);
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
 * @see     \blaze\cache\Cache
 * @since   1.0
 * @author Christian Beikov
 */
final class CacheManager{

    private static $rootInstances = array();
    private $parent;
    private $children = array();
    private $key;
    private $cache;

    /**
     * Creates a new instance of CacheManager
     *
     * @param CacheManager $parent The parent cache manager for hierachical caching
     * @param string $key The key with which the hierachy is made by appending
     * @param Cache $cache The cache implementation which is used for caching
     */
    private function __construct($parent, $key, Cache $cache) {
        $this->parent = $parent;
        $this->key = $key;
        $this->cache = $cache;
    }

    /**
     * Checks the key and returns it as native string when wrapper is false, otherwise as blaze\lang\String.
     * @return string|blaze\lang\String
     */
    private static function getCheckedKey($key, $wrapper = false){
        if($wrapper){
            $key = \blaze\lang\String::asWrapper($key);

            if($key->length() < 1)
                throw new CacheException('The length of the key must be at least one char!');
        }else{
            $key = \blaze\lang\String::asNative($key);

            if(strlen($key) < 1)
                throw new CacheException('The length of the key must be at least one char!');
        }

        return $key;
    }

    /**
     * Returns a root CacheManager instance for the given key. If a CacheManager
     * for the given key has already been initialized then the cache parameter
     * is ignored. If no cache for the given key is available, then a new
     * CacheManager instance is created with the given cache parameter. If
     * no instance is available for the given key and the cache is null, null is returned.
     *
     * @param string|blaze\lang\String $key The key to which the CacheManager instance should be mapped
     * @param Cache $cache The cache which should be used for the CacheManager
     * @return blaze\cache\CacheManager Returns a CacheManager or null if no entry for the key is available and the parameter cache is null
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public static function getInstance($key, Cache $cache = null){
        $key = self::getCheckedKey($key);
        
        if(!array_key_exists($key, self::$rootInstances)){
            if($cache !== null)
                return self::$rootInstances[$key] = new self(null, $key, $cache);
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
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function getChild($key){
        $key = self::getCheckedKey($key);
        if(!array_key_exists($key, $this->children))
            $this->children[$key] = new self($this, $this->key.'.'.$key, $this->cache);
        return $this->children[$key];
    }

    /**
     * Caches the given value into the cache with the instance key concatenated with the given key as new key.
     *
     * @param string|blaze\lang\String $key The key to which the value should be mapped
     * @param mixed|blaze\lang\Object $value The value which should be cached
     * @return boolean True if the caching action was successfull, otherwise false
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function put($key, $value){
        $this->cache->put($this->key.'.'.self::getCheckedKey($key), $value);
    }

    /**
     * Puts all entries of the map into the cache in an more efficient way than
     * putting them as single entries with put(key, value) into it.
     * The key of the map must be a string, otherwise the toString Method is used for the key.
     *
     * @param \blaze\collections\Map $map The map which contains the entries which should be put into the cache
     * @return boolean true if all entries were put into the cache, otherwise false
     * @throws CacheException Is thrown when a key has less than one char.
     */
    public function putAll(\blaze\collections\Map $map) {
        $newMap = new \blaze\collections\map\HashMap();

        foreach($map as $key => $value){
            $newMap->put($this->key.'.'.self::getCheckedKey($key), $value);
        }

        return $this->cache->putAll($newMap);
    }

    /**
     * This method checks wether the key exists in the cache or not, it is
     * not responsible to check for null.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function contains($key){
        return $this->cache->contains($this->key.'.'.self::getCheckedKey($key));
    }

    /**
     * This method checks wether a key with keyPrefix exists in the cache or not, it is
     * not responsible to check for null.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of the key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function containsByPrefix($keyPrefix){
        return $this->cache->containsByPrefix($this->key.'.'.self::getCheckedKey($keyPrefix));
    }

    /**
     * This method checks wether a key with keySuffix exists in the cache or not.
     *
     * @param string|blaze\lang\String $keySuffix The suffix of the key which to look for in the cache
     * @return boolean True if an entry in the cache exists, otherwise false
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function containsBySuffix($keySuffix){
        return $this->cache->containsBySuffix('/'.$this->key.'\\..*'.self::getCheckedKey($keySuffix));
    }

    /**
     * This method checks wether the regex matches to any key in the cache or not.
     *
     * @param string|blaze\lang\String $regex The regex which a key has to match
     * @return boolean True if an entry in the cache exists, otherwise false
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function containsByRegex($regex){
        $regex = self::getCheckedKey($regex, true);
        return $this->cache->containsBySuffix($regex->charAt(0).$this->key.'\\.'.$regex->substring(1));
    }

    /**
     * This method locks the cache to get a consistent value and returns it. If
     * the key is not available in the cache, null is returned.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return mixed|blaze\lang\Object The value or null if no cache can be found.
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function get($key){
        return $this->cache->get($this->key.'.'.self::getCheckedKey($key));
    }

    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries which start with the given keyPrefix are returned as a list.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys that start with keyPrefix, or an empty map
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function getByPrefix($keyPrefix){
        return $this->cache->getByPrefix($this->key.'.'.self::getCheckedKey($keyPrefix));
    }
    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries which start with the given keyPrefix are returned as a list.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys that start with keyPrefix, or an empty map
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function getBySuffix($keySuffix){
        return $this->cache->getByRegex('/'.$this->key.'\\..*'.self::getCheckedKey($keySuffix));
    }

    /**
     * First the cache gets locked to be able to get consistent values. The keys
     * of the cache entries match the regex are returned as a map.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $regex The regex which a key has to match
     * @return blaze\collections\Map Reruns a map which represents the cache entries which have keys match the regex, or an empty map
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function getByRegex($regex){
        $regex = self::getCheckedKey($regex, true);
        return $this->cache->getByRegex($regex->charAt(0).$this->key.'\\.'.$regex->substring(1));
    }

    /**
     * Locks the cache to consistently invalidate the cache entry with the given key.
     * The lock is released after this action.
     *
     * @param string|blaze\lang\String $key The key which to look for in the cache
     * @return boolean False if the cache entry could not be invalidated, otherwise true
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function remove($key){
        $this->cache->remove($this->key.'.'.self::getCheckedKey($key));
    }

    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys start with the CacheManager key get invalidated.
     *
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     */
    public function clear(){
        $this->cache->removeByPrefix($this->key);
    }

    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys start with the given keyPrefix get invalidated.
     *
     * @param string|blaze\lang\String $keyPrefix The prefix of a key which to look for in the cache
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function removeByPrefix($keyPrefix){
        $this->cache->removeByPrefix($this->key.'.'.self::getCheckedKey($keyPrefix));
    }

    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys end with the given keySuffix get invalidated.
     *
     * @param string|blaze\lang\String $keySuffix The suffix of a key which to look for in the cache
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function removeBySuffix($keySuffix){
        return $this->cache->removeByRegex('/'.$this->key.'\\..*'.self::getCheckedKey($keySuffix));
    }

    /**
     * Locks the cache to consistently invalidate cache entries. Entries which
     * keys match the given regex get invalidated.
     *
     * @param string|blaze\lang\String $regex The regex which a key has to match
     * @return boolean False if one or more of the cache entries could not be invalidated, otherwise true
     * @throws CacheException Is thrown when the key has less than one char.
     */
    public function removeByRegex($regex){
        $regex = self::getCheckedKey($regex, true);
        return $this->cache->removeByRegex($regex->charAt(0).$this->key.'\\.'.$regex->substring(1));
    }
}
?>
