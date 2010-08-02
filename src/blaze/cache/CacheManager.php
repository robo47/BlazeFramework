<?php
namespace blaze\cache;

/**
 * Description of CacheManager
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author Christian Beikov
 * @todo    Implementation and documentation.
 */
final class CacheManager{

    private static $rootInstance;
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
     *
     * @param mixed $key
     * @param Cacher $cacher
     * @return blaze\cache\CacheManager
     */
    public static function getInstance($key, Cacher $cacher){
        if(self::$rootInstance == null)
            self::$rootInstance = new self(null, $key, $cacher);
        return self::$rootInstance;
    }

    public function getChild($key){
        if(!array_key_exists($key, $this->children))
            $this->children[$key] = self($this, $this->key.'.'.$key, $this->cacher);
        return $this->children[$key];
    }

    public function doCache($key, $value){
        $this->cacher->doCache($this->key.'.'.$key, $value);
    }

    public function isCached($key){
        return $this->cacher->isCached($this->key.'.'.$key);
    }

    public function getCache($key){
        return $this->cacher->getCache($this->key.'.'.$key);
    }

    public function invalidate($key){
        $this->cacher->invalidate($this->key.'.'.$key);
    }

    public function invalidateAll(){
        $this->cacher->invalidateAll($this->key);
    }
}
?>
