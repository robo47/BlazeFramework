<?php
namespace blaze\cache;

/**
 * Caches values to files into the given directory and locks the files when
 * read or write actions are processed. The cache directory is in a standard project dir.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @since   1.0
 * @author Christian Beikov
 */
class LocalCacher implements Cacher, \blaze\lang\Singleton {

    private static $instance;
    /**
     *
     * @var blaze\io\File
     */
    private $cacheDir;
    private $cached = array();

    private function __construct(\blaze\io\File $dir){
        $this->cacheDir = $dir;
    }

    /**
     *
     * @return blaze\cache\Cacher
     */
    public static function getInstance() {
        if(self::$instance == null){
            self::$instance = new self(new \blaze\io\File(\blaze\lang\ClassLoader::getSystemClassLoader()->getClassPath()->toNative().'/../cache'));
        }

        return self::$instance;
    }
    public function doCache($key, $value){
                $this->cached[$key] = $value;
        $f = new \blaze\io\File($this->cacheDir, $key);
        $h = fopen($f->getAbsolutePath(), 'w');
        fwrite($h, serialize($value));
        fclose($h);
    }
    public function isCached($key){
        if(array_key_exists($key, $this->cached))
                return true;
        $f = new \blaze\io\File($this->cacheDir, $key);
        return $f->exists();
    }
    public function getCache($key){
        if(array_key_exists($key, $this->cached))
                return $this->cached[$key];
        $f = new \blaze\io\File($this->cacheDir, $key);
        if(!$f->exists())
            throw new CacheNotFoundException($key);
        return $this->cached[$key] = unserialize(file_get_contents($f->getAbsolutePath()));
    }
    public function getCacheEntries($keyPrefix){
        $map = new \blaze\collections\map\HashMap();

        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->startsWith($keyPrefix))
                        $map->put($file->getFileName(), unserialize(file_get_contents($file->getAbsolutePath())));
        return $map;
    }
    public function invalidate($key){
        if(array_key_exists($key, $this->cached))
                unset($this->cached[$key]);
        $f = new \blaze\io\File($this->cacheDir, $key);
        if($f->exists())
            $f->delete();
    }
    public function invalidateAll($keyPrefix){
        foreach(array_keys($this->cached) as $key){
            if(strpos($key, $keyPrefix) == 0)
                    unset($this->cached[$key]);
        }
        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->startsWith($keyPrefix))
                        $file->delete();
    }
}
?>
