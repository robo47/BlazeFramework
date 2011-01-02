<?php
namespace blaze\cache;

/**
 * Caches values to files into the given directory and locks the files when
 * read or write actions are processed. The cache directory is in a standard project dir.
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @author Christian Beikov
 */
class LocalCache implements Cache, \blaze\lang\StaticInitialization {

    /**
     * The standard directory in which to write cache entries.
     *
     * @var blaze\io\File
     */
    private static $standardDir;
    /**
     * The concrete directory in which to write cache entries.
     *
     * @var blaze\io\File
     */
    private $cacheDir;

    /**
     * Creates a new cache instance for the given directory.
     *
     * @param \blaze\io\File $dir The directory which shall be used for caching
     */
    public function __construct(\blaze\io\File $dir = null){
        if($dir !== null)
            $this->cacheDir = $dir;
        else
            $this->cacheDir = self::$standardDir;

        if(!$this->cacheDir->canWrite())
                throw new CacheException('Can not write to the given directory!');
    }

    /**
     * @access private
     */
    public static function staticInit() {
        self::$standardDir = new \blaze\io\File(\blaze\lang\ClassLoader::getSystemClassLoader()->getClassPath()->toNative().'/../cache');
    }

    /**
     * {@inheritDoc}
     */
    public function put($key, $value){
        $f = new \blaze\io\File($this->cacheDir, $key);
        $h = fopen($f->getAbsolutePath(), 'w');
        fwrite($h, serialize($value));
        fclose($h);
    }

    /**
     * {@inheritDoc}
     */
    public function putAll(\blaze\collections\Map $map) {
        foreach($map as $key => $value){
            $f = new \blaze\io\File($this->cacheDir, $key);
            $h = fopen($f->getAbsolutePath(), 'w');
            fwrite($h, serialize($value));
            fclose($h);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function contains($key){
        $f = new \blaze\io\File($this->cacheDir, $key);
        return $f->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function containsByPrefix($keyPrefix){
        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->startsWith($keyPrefix))
                        return true;
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function containsBySuffix($keySuffix){
        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->endsWith($keySuffix))
                        return true;
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function containsByRegex($regex){
        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->matches($regex))
                        return true;
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function get($key){
        $f = new \blaze\io\File($this->cacheDir, $key);
        if(!$f->exists())
            return null;
        return $this->cached[$key] = unserialize(file_get_contents($f->getAbsolutePath()));
    }

    /**
     * {@inheritDoc}
     */
    public function getByPrefix($keyPrefix){
        $map = new \blaze\collections\map\HashMap();

        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->startsWith($keyPrefix))
                        $map->put($file->getFileName(), unserialize(file_get_contents($file->getAbsolutePath())));
        return $map;
    }

    /**
     * {@inheritDoc}
     */
    public function getBySuffix($keySuffix){
        $map = new \blaze\collections\map\HashMap();

        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->endsWith($keySuffix))
                        $map->put($file->getFileName(), unserialize(file_get_contents($file->getAbsolutePath())));
        return $map;
    }

    /**
     * {@inheritDoc}
     */
    public function getByRegex($regex){
        $map = new \blaze\collections\map\HashMap();

        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->matches($regex))
                        $map->put($file->getFileName(), unserialize(file_get_contents($file->getAbsolutePath())));
        return $map;
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key){
        $f = new \blaze\io\File($this->cacheDir, $key);
        if($f->exists())
            $f->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function removeByPrefix($keyPrefix){
        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->startsWith($keyPrefix))
                        $file->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function removeBySuffix($keySuffix){
        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->endsWith($keySuffix))
                        $file->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function removeByRegex($regex){
        foreach($this->cacheDir->listFiles() as $file)
                if($file->getName()->matches($regex))
                        $file->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function clear(){
        foreach($this->cacheDir->listFiles() as $file)
                        $file->delete();
    }
}
?>
