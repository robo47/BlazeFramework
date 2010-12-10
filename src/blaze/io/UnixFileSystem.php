<?php
namespace blaze\io;

/**
 * UnixFileSystem class. This class encapsulates the basic file system functions
 * for platforms using the unix (posix)-stylish filesystem. It wraps php native
 * functions suppressing normal PHP error reporting and instead uses Exception
 * to report and error.
 *
 * This class is part of a oop based filesystem abstraction and targeted to run
 * on all supported php platforms.
 *
 * Note: For debugging turn track_errors on in the php.ini. The error messages
 * and log messages from this class will then be clearer because $php_errormsg
 * is passed as part of the message.
 *
 * FIXME:
 *  - Comments
 *  - Error handling reduced to min, error are handled by File mainly
 *
 */
class UnixFileSystem extends FileSystem {

    /**
     * returns OS dependant path separator char
     */
    public function getDirectorySeparator() {
        return '/';
    }

    /**
     * returns OS dependant directory separator char
     */
    public function getPathSeparator() {
        return ':';
    }

    /**
     * A normal Unix pathname contains no duplicate slashes and does not end
     * with a slash.  It may be the empty string.
     *
     * Check that the given pathname is normal.  If not, invoke the real
     * normalizer on the part of the pathname that requires normalization.
     * This way we iterate through the whole pathname string only once.
     */
    public function normalize($strPathname) {
        
        if (!strlen($strPathname)) {
            return;
        }
        
        // Resolve home directories. We assume /home is where all home
        // directories reside, b/c there is no other way to do this with
        // PHP AFAIK.
        if ($strPathname{0} === "~") {
            if ($strPathname{1} === "/") { // like ~/foo => /home/user/foo
                $strPathname = "/home/" . get_current_user() . substr($strPathname, 1);
            } else { // like ~foo => /home/foo
                $pos = strpos($strPathname, "/");
                $name = substr($strPathname, 1, $pos - 2);
                $strPathname = "/home/" . $name . substr($strPathname, $pos);
            }
        }

        $n = strlen($strPathname);
        $prevChar = 0;
        for ($i=0; $i < $n; $i++) {
            $c = $strPathname{$i};
            if (($prevChar === '/') && ($c === '/')) {
                return self::normalizer($strPathname, $n, $i - 1);
            }
            $prevChar = $c;
        }
        if ($prevChar === '/') {
            return self::normalizer($strPathname, $n, $n - 1);
        }
        return $strPathname;
    }

    /**
     * Normalize the given pathname, whose length is $len, starting at the given
     * $offset; everything before this offset is already normal.
     */
    protected function normalizer($pathname, $len, $offset) {
        if ($len === 0) {
            return $pathname;
        }
        $n = (int) $len;
        while (($n > 0) && ($pathname{$n-1} === '/')) {
            $n--;
        }
        if ($n === 0) {
            return '/';
        }
        $sb = "";

        if ($offset > 0) {
            $sb .= substr($pathname, 0, $offset);
        }
        $prevChar = 0;
        for ($i = $offset; $i < $n; $i++) {
            $c = $pathname{$i};
            if (($prevChar === '/') && ($c === '/')) {
                continue;
            }
            $sb .= $c;
            $prevChar = $c;
        }
        return $sb;
    }

    /**
     * Compute the length of the pathname string's prefix.  The pathname
     * string must be in normal form.
     */
    public function prefixLength($pathname) {
        if (strlen($pathname === 0)) {
            return 0;
        }
        return (($pathname{0} === '/') ? 1 : 0);
    }

    /**
     * Resolve the child pathname string against the parent.
     * Both strings must be in normal form, and the result
     * will be in normal form.
     */
    public function resolve($parent, $child) {

        if ($child === "") {
            return $parent;
        }

        if ($child{0} === '/') {
            if ($parent === '/') {
                return $child;
            }
            return $parent.$child;
        }

        if ($parent === '/') {
            return $parent.$child;
        }

        return $parent.'/'.$child;
    }

    public function getDefaultParent() {
        return '/';
    }

    public function isAbsolute(File $f) {
        return ($f->getPrefixLength() !== 0);
    }

    /**
     * the file resolver
     */
    public function resolveFile(File $f) {
        // resolve if parent is a file oject only
        if ($this->isAbsolute($f)) {
            return $f->getPath()->toNative();
        } else {
            return $this->resolve(\blaze\lang\System::getProperty("user.dir"), $f->getPath()->toNative());
        }       
    }

    /* -- most of the following is mapped to the php natives wrapped by FileSystem */    

    /* -- Attribute accessors -- */
    public function getBooleanAttributes(&$f) {
        //$rv = getBooleanAttributes0($f);
        $name = $f->getName()->toNative();
        $hidden = (strlen($name) > 0) && ($name{0} == '.');
        return ($hidden ? $this->BA_HIDDEN : 0);
    }

    /**
     * set file readonly on unix
     */
    public function setReadOnly($f) {
        if ($f instanceof File) {
            $strPath = (string) $f->getPath()->toNative();
            $perms = (int) (@fileperms($strPath) & 0444);
            return FileSystem::Chmod($strPath, $perms);
        } else {
            throw new Exception("IllegalArgutmentType: Argument is not File");
        }
    }

    /**
     * compares file paths lexicographically
     */
    public function compare(File $f1, File $f2) {
        if ( ($f1 instanceof File) && ($f2 instanceof File) ) {
            $f1Path = $f1->getPath()->toNative();
            $f2Path = $f2->getPath()->toNative();
            return (boolean) strcmp((string) $f1Path, (string) $f2Path);
        } else {
            throw new Exception("IllegalArgutmentType: Argument is not File");
        }
    }

    /**
     * Copy a file, takes care of symbolic links
     *
     * @param File $src Source path and name file to copy.
     * @param File $dest Destination path and name of new file.
     *
     * @return void     
     * @throws Exception if file cannot be copied.
     */
    public function copy(File $src, File $dest) {
        global $php_errormsg;
        
        if (!$src->isLink())
        {
            return parent::copy($src, $dest);
        }
        
        $srcPath  = $src->getAbsolutePath()->toNative();
        $destPath = $dest->getAbsolutePath()->toNative();
        
        $linkTarget = $src->getLinkTarget();
        if (false === @symlink($linkTarget, $destPath))
        {
            $msg = "FileSystem::copy() FAILED. Cannot create symlink from $destPath to $linkTarget.";
            throw new Exception($msg);
        }
    }
    
    /* -- fs interface --*/

    public function listRoots() {
        if (!$this->checkAccess('/', false)) {
            die ("Can not access root");
        }
        return array(new File("/"));
    }

    /**
     * returns the contents of a directory in an array
     */
    public function lister(File $f, $filter = null) {
        $dir = @opendir($f->getAbsolutePath()->toNative());
        if (!$dir) {
            throw new Exception("Can't open directory " . $f->toString());
        }
        $vv = array();
        while (($file = @readdir($dir)) !== false) {
            if ($file == "." || $file == "..") {
                continue;
            }
            $vv[] = (string) $file;
        }
        @closedir($dir);
        return $vv;
    }

    public function fromURLPath($p) {
        if (StringHelper::endsWith("/", $p) && (strlen($p) > 1)) {

            // "/foo/" --> "/foo", but "/" --> "/"            
            $p = substr($p, 0, strlen($p) - 1);

        }

        return $p;
    }
    
    /**
     * Whether file can be deleted.
     * @param File $f
     * @return boolean
     */
    public function canDelete(File $f)
    { 
        @clearstatcache(); 
        $dir = dirname($f->getAbsolutePath()->toNative());
        return (bool) @is_writable($dir); 
    }
    
}
