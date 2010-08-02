<?php
namespace blaze\cache;

/**
 * Description of LocalCacher
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author Christian Beikov
 * @todo    Implementation and documentation.
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
            self::$instance = new self(new \blaze\io\File(\blaze\lang\ClassLoader::getClassPath().'/../cache'));
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
