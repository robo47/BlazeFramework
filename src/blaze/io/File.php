<?php

namespace blaze\io;

use blaze\lang\Object,
 blaze\lang\String,
 blaze\lang\System,
 blaze\lang\NullPointerException,
 blaze\lang\StaticInitialization,
 blaze\lang\IllegalArgumentException,
 blaze\lang\Comparable,
 blaze\lang\ClassCastException;

/**
 * Description of File
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Implementation and documentation.
 */
class File extends Object implements StaticInitialization, Serializable, Comparable {

    /**
     * The absolute path to the file which is represented by the object.
     * @var string The absolute path to the file.
     */
    private $path;
    /**
     * The length of this abstract pathname's prefix, or zero if it has no prefix.
     * @var int
     */
    private $prefixLength = 0;
    /**
     *
     * @var blaze\io\FileSystem
     */
    private static $fs;
    /**
     * Path separator string from FileSystem
     * @var string
     */
    public static $pathSeparator;
    /**
     * Directory separator string from FileSystem
     * @var string
     */
    public static $directorySeparator;

    public static function staticInit() {
        self::$fs = FileSystem::getInstance();
        self::$pathSeparator = self::$fs->getPathSeparator();
        self::$directorySeparator = self::$fs->getDirectorySeparator();
    }

    /**
     * Description of the constructor of File
     * @param blaze\io\File|string|blaze\lang\String $parent The parent File-object or a string which represents a path
     * @param int|string|blaze\lang\String $childOrPrefixLength The child pathname or the prefix length
     */
    public function __construct($parent = null, $childOrPrefixLength = null) {
        /* simulate signature identified constructors */
        if ($parent instanceof File && String::isType($childOrPrefixLength)) {
            $this->constructFileParentStringChild($parent, String::asNative($childOrPrefixLength));
        } elseif (String::isType($parent) && ($childOrPrefixLength === null)) {
            $this->constructPathname(String::asNative($parent));
        } elseif (String::isType($parent) && String::isType($childOrPrefixLength)) {
            $this->constructStringParentStringChild(String::asNative($parent), String::asNative($childOrPrefixLength));
        } else {
            if ($parent === null) {
                throw new NullPointerException("Parent may not be null");
            }
            $this->path = String::asWrapper($parent);
            $this->prefixLength = (int) $childOrPrefixLength;
        }
    }

    /* -- constructors not called by signature match, so we need some helpers -- */

    private function constructPathname($pathname) {
        if ($pathname === null) {
            throw new NullPointerException("Argument to function must not be null");
        }

        $this->path = String::asWrapper(self::$fs->normalize($pathname));
        $this->prefixLength = (int) self::$fs->prefixLength($this->path->toNative());
    }

    private function constructStringParentStringChild($parent, $child = null) {
        if ($child === null) {
            throw new NullPointerException("Argument to function must not be null");
        }
        if ($parent !== null) {
            if ($parent === "") {
                $this->path = self::$fs->resolve(self::$fs->getDefaultParent(), self::$fs->normalize($child));
            } else {
                $this->path = self::$fs->resolve(self::$fs->normalize($parent), self::$fs->normalize($child));
            }
        } else {
            $this->path = self::$fs->normalize($child);
        }
        $this->path = String::asWrapper($this->path);
        $this->prefixLength = (int) self::$fs->prefixLength($this->path->toNative());
    }

    private function constructFileParentStringChild(File $parent, $child = null) {
        if ($child === null) {
            throw new NullPointerException("Argument to function must not be null");
        }

        if ($parent !== null) {
            if ($parent->path === "") {
                $this->path = self::$fs->resolve(self::$fs->getDefaultParent(), self::$fs->normalize($child));
            } else {
                $this->path = self::$fs->resolve($parent->path, self::$fs->normalize($child));
            }
        } else {
            $this->path = self::$fs->normalize($child);
        }
        $this->path = String::asWrapper($this->path);
        $this->prefixLength = self::$fs->prefixLength($this->path->toNative());
    }

    /* -- Path-component accessors -- */

    /**
     * Returns the name of the file or directory denoted by this abstract
     * pathname.  This is just the last name in the pathname's name
     * sequence.  If the pathname's name sequence is empty, then the empty
     * string is returned.
     *
     * @return blaze\lang\String The name of the file or directory denoted by this abstract
     *          pathname, or the empty string if this pathname's name sequence
     *          is empty
     */
    public function getName() {
        $index = $this->path->lastIndexOf(self::$directorySeparator);
        if ($index < $this->prefixLength) {
            return $this->path->substring($this->prefixLength);
        }
        return $this->path->substring($index + 1);
    }

    /** Returns the length of this abstract pathname's prefix. */
    public function getPrefixLength() {
        return (int) $this->prefixLength;
    }

    /**
     * Returns the pathname string of this abstract pathname's parent, or
     * null if this pathname does not name a parent directory.
     *
     * The parent of an abstract pathname consists of the pathname's prefix,
     * if any, and each name in the pathname's name sequence except for the last.
     * If the name sequence is empty then the pathname does not name a parent
     * directory.
     *
     * @return blaze\lang\String The pathname string of the parent directory named by this
     *          abstract pathname, or null if this pathname does not name a parent
     */
    public function getParent() {
        $index = $this->path->lastIndexOf(self::$directorySeparator);
        if ($index < $this->prefixLength) {
            if (($this->prefixLength > 0) && ($this->path->length() > $this->prefixLength)) {
                return $this->path->substring(0, $this->prefixLength);
            }
            return null;
        }
        return $this->path->substring(0, $index);
    }

    /**
     * Returns the abstract pathname of this abstract pathname's parent,
     * or null if this pathname does not name a parent directory.
     *
     * The parent of an abstract pathname consists of the pathname's prefix,
     * if any, and each name in the pathname's name sequence except for the
     * last.  If the name sequence is empty then the pathname does not name
     * a parent directory.
     *
     * @return  The abstract pathname of the parent directory named by this
     *          abstract pathname, or null if this pathname
     *          does not name a parent
     */
    public function getParentFile() {
        $p = $this->getParent();
        if ($p === null) {
            return null;
        }
        return new File($p, (int) $this->prefixLength);
    }

    /**
     * Converts this abstract pathname into a pathname string.  The resulting
     * string uses the default name-separator character to separate the names
     * in the name sequence.
     *
     * @return blaze\lang\String The string form of this abstract pathname
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Returns path without leading basedir.
     *
     * @param string $basedir Base directory to strip
     *
     * @return string Path without basedir
     *
     * @uses getPath()
     */
    public function getPathWithoutBase($basedir) {
        if (!StringHelper::endsWith(self::$directorySeparator, $basedir)) {
            $basedir .= self::$directorySeparator;
        }
        $path = $this->getPath()->toNative();
        if (!substr($path, 0, strlen($basedir)) == $basedir) {
            //path does not begin with basedir, we don't modify it
            return $path;
        }
        return substr($path, strlen($basedir));
    }

    /**
     * Tests whether this abstract pathname is absolute.  The definition of
     * absolute pathname is system dependent.  On UNIX systems, a pathname is
     * absolute if its prefix is "/".  On Win32 systems, a pathname is absolute
     * if its prefix is a drive specifier followed by "\\", or if its prefix
     * is "\\".
     *
     * @return  true if this abstract pathname is absolute, false otherwise
     */
    public function isAbsolute() {
        return ($this->prefixLength !== 0);
    }

    /**
     * Returns the absolute pathname string of this abstract pathname.
     *
     * If this abstract pathname is already absolute, then the pathname
     * string is simply returned as if by the getPath method.
     * If this abstract pathname is the empty abstract pathname then
     * the pathname string of the current user directory, which is named by the
     * system property user.dir, is returned.  Otherwise this
     * pathname is resolved in a system-dependent way.  On UNIX systems, a
     * relative pathname is made absolute by resolving it against the current
     * user directory.  On Win32 systems, a relative pathname is made absolute
     * by resolving it against the current directory of the drive named by the
     * pathname, if any; if not, it is resolved against the current user
     * directory.
     *
     * @return  blaze\lang\String The absolute pathname string denoting the same file or
     *          directory as this abstract pathname
     * @see     #isAbsolute()
     */
    public function getAbsolutePath() {

        return new String(self::$fs->resolveFile($this));
    }

    /**
     * Returns the absolute form of this abstract pathname.  Equivalent to
     * getAbsolutePath.
     *
     * @return  The absolute abstract pathname denoting the same file or
     *          directory as this abstract pathname
     */
    public function getAbsoluteFile() {
        return new File($this->getAbsolutePath());
    }

    /**
     * Returns the canonical pathname string of this abstract pathname.
     *
     * A canonical pathname is both absolute and unique. The precise
     * definition of canonical form is system-dependent. This method first
     * converts this pathname to absolute form if necessary, as if by invoking the
     * getAbsolutePath() method, and then maps it to its unique form in a
     * system-dependent way.  This typically involves removing redundant names
     * such as "." and .. from the pathname, resolving symbolic links
     * (on UNIX platforms), and converting drive letters to a standard case
     * (on Win32 platforms).
     *
     * Every pathname that denotes an existing file or directory has a
     * unique canonical form.  Every pathname that denotes a nonexistent file
     * or directory also has a unique canonical form.  The canonical form of
     * the pathname of a nonexistent file or directory may be different from
     * the canonical form of the same pathname after the file or directory is
     * created.  Similarly, the canonical form of the pathname of an existing
     * file or directory may be different from the canonical form of the same
     * pathname after the file or directory is deleted.
     *
     * @return  blaze\lang\String The canonical pathname string denoting the same file or
     *          directory as this abstract pathname
     */
    public function getCanonicalPath() {

        return new String(self::$fs->canonicalize($this->path->toNative()));
    }

    /**
     * Returns the canonical form of this abstract pathname.  Equivalent to
     * getCanonicalPath(.
     *
     * @return  File The canonical pathname string denoting the same file or
     *          directory as this abstract pathname
     */
    public function getCanonicalFile() {
        return new File($this->getCanonicalPath());
    }

    /**
     * Converts this abstract pathname into a file: URL.  The
     * exact form of the URL is system-dependent.  If it can be determined that
     * the file denoted by this abstract pathname is a directory, then the
     * resulting URL will end with a slash.
     *
     * Usage note: This method does not automatically escape
     * characters that are illegal in URLs.  It is recommended that new code
     * convert an abstract pathname into a URL by first converting it into a
     * URL, via the toURL() method, and then converting the URL
     * into a URL via the URL::toURL()
     *
     * @return  A URL object representing the equivalent file URL
     *
     *
     */
    public function toURL() {
        /*
          // URL class not implemented yet
          return new URL("file", "", $this->slashify($this->getAbsolutePath(), $this->isDirectory()));
         */
    }

    /**
     * Constructs a file: URL that represents this abstract pathname.
     * Not implemented yet
     */
    public function toURI() {
        /*
          $f = $this->getAbsoluteFile();
          $sp = (string) $this->slashify($f->getPath(), $f->isDirectory());
          if (StringHelper::startsWith('//', $sp))
          $sp = '//' + sp;
          return new URL('file', null, $sp, null);
         */
    }

    private function slashify($path, $isDirectory) {
        $p = (string) $path;

        if (self::$directorySeparator !== '/') {
            $p = str_replace(self::$directorySeparator, '/', $p);
        }

        if (!StringHelper::startsWith('/', $p)) {
            $p = '/' . $p;
        }

        if (!StringHelper::endsWith('/', $p) && $isDirectory) {
            $p = $p . '/';
        }

        return $p;
    }

    /* -- Attribute accessors -- */

    /**
     * Tests whether the application can read the file denoted by this
     * abstract pathname.
     *
     * @return  true if and only if the file specified by this
     *          abstract pathname exists and can be read by the
     *          application; false otherwise
     */
    public function canRead() {


        if (self::$fs->checkAccess($this, FileSystem::ACCESS_READ)) {
            return (boolean) @is_readable($this->getAbsolutePath()->toNative());
        }
        return false;
    }

    /**
     * Tests whether the application can modify to the file denoted by this
     * abstract pathname.
     *
     * @return  true if and only if the file system actually
     *          contains a file denoted by this abstract pathname and
     *          the application is allowed to write to the file;
     *          false otherwise.
     *
     */
    public function canWrite() {

        return self::$fs->checkAccess($this, FileSystem::ACCESS_WRITE);
    }

    /**
     * Tests whether the application can execute the file denoted by this
     * abstract pathname.
     *
     * @return  true if and only if the file system actually
     *          contains a file denoted by this abstract pathname and
     *          the application is allowed to execute the file;
     *          false otherwise.
     *
     */
    public function canExecute() {

        return self::$fs->checkAccess($this, FileSystem::ACCESS_EXECUTE);
    }

    /**
     * Tests whether the file denoted by this abstract pathname exists.
     *
     * @return  true if and only if the file denoted by this
     *          abstract pathname exists; false otherwise
     *
     */
    public function exists() {
        clearstatcache();

        if (is_link($this->path->toNative())) {
            return true;
        } else if ($this->isFile()) {
            return @file_exists($this->path->toNative()) || is_link($this->path->toNative());
        } else {
            return @is_dir($this->path->toNative());
        }
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a
     * directory.
     *
     * @return true if and only if the file denoted by this
     *         abstract pathname exists and is a directory;
     *         false otherwise
     *
     */
    public function isDirectory() {
        clearstatcache();

        if (self::$fs->checkAccess($this, FileSystem::ACCESS_READ) !== true) {
            throw new IOException("No read access to " . $this->path->toNative());
        }
        return @is_dir($this->path->toNative()) && !@is_link($this->path->toNative());
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a normal
     * file.  A file is normal if it is not a directory and, in
     * addition, satisfies other system-dependent criteria.  Any non-directory
     * file created by a Java application is guaranteed to be a normal file.
     *
     * @return  true if and only if the file denoted by this
     *          abstract pathname exists and is a normal file;
     *          false otherwise
     */
    public function isFile() {
        clearstatcache();
        //
        return @is_file($this->path->toNative());
    }

    /**
     * Tests whether the file named by this abstract pathname is a hidden
     * file.  The exact definition of hidden is system-dependent.  On
     * UNIX systems, a file is considered to be hidden if its name begins with
     * a period character ('.').  On Win32 systems, a file is considered to be
     * hidden if it has been marked as such in the filesystem. Currently there
     * seems to be no way to dermine isHidden on Win file systems via PHP
     *
     * @return  true if and only if the file denoted by this
     *          abstract pathname is hidden according to the conventions of the
     *          underlying platform
     */
    public function isHidden() {

        if (self::$fs->checkAccess($this) !== true) {
            throw new IOException("No read access to " . $this->path->toNative());
        }
        return ((self::$fs->getBooleanAttributes($this) & self::$fs->BA_HIDDEN) !== 0);
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a symbolic link.
     *
     * @return  true if and only if the file denoted by this
     *          abstract pathname exists and is a symbolic link;
     *          false otherwise
     */
    public function isLink() {
        clearstatcache();

        if (self::$fs->checkAccess($this) !== true) {
            throw new IOException("No read access to " . $this->path->toNative());
        }
        return @is_link($this->path->toNative());
    }

    /**
     * Returns the target of the symbolic link denoted by this abstract pathname
     *
     * @return  the target of the symbolic link denoted by this abstract pathname
     */
    public function getLinkTarget() {
        return @readlink($this->path->toNative());
    }

    /**
     * Returns the time that the file denoted by this abstract pathname was
     * last modified.
     *
     * @return  A int value representing the time the file was
     *          last modified, measured in milliseconds since the epoch
     *          (00:00:00 GMT, January 1, 1970), or 0 if the
     *          file does not exist or if an I/O error occurs
     */
    public function lastModified() {

        if (self::$fs->checkAccess($this) !== true) {
            throw new IOException("No read access to " . $this->path->toNative());
        }
        return self::$fs->getLastModifiedTime($this);
    }

    /**
     * Returns the length of the file denoted by this abstract pathname.
     * The return value is unspecified if this pathname denotes a directory.
     *
     * @return  The length, in bytes, of the file denoted by this abstract
     *          pathname, or 0 if the file does not exist
     */
    public function length() {

        if (self::$fs->checkAccess($this) !== true) {
            throw new IOException("No read access to " . $this->path->toNative() . "\n");
        }
        return self::$fs->getLength($this);
    }

    /**
     * Convenience method for returning the contents of this file as a string.
     * This method uses file_get_contents() to read file in an optimized way.
     * @return string
     * @throws Exception - if file cannot be read
     */
    public function contents() {
        if (!$this->canRead() || !$this->isFile()) {
            throw new IOException("Cannot read file contents!");
        }
        return file_get_contents($this->getAbsolutePath()->toNative());
    }

    /* -- File operations -- */

    /**
     * Atomically creates a new, empty file named by this abstract pathname if
     * and only if a file with this name does not yet exist.  The check for the
     * existence of the file and the creation of the file if it does not exist
     * are a single operation that is atomic with respect to all other
     * filesystem activities that might affect the file.
     *
     * @return  true if the named file does not exist and was
     *          successfully created; <code>false</code> if the named file
     *          already exists
     * @throws IOException if file can't be created
     */
    public function createNewFile($parents=true, $mode=0777) {
        $file = self::$fs->createNewFile($this->path->toNative());
        return $file;
    }

    /**
     * Deletes the file or directory denoted by this abstract pathname.  If
     * this pathname denotes a directory, then the directory must be empty in
     * order to be deleted.
     *
     * @return  true if and only if the file or directory is
     *          successfully deleted; false otherwise
     */
    public function delete($recursive = false) {

        if (self::$fs->canDelete($this) !== true) {
            throw new IOException("Cannot delete " . $this->path->toNative() . "\n");
        }
        return self::$fs->delete($this, $recursive);
    }

    /**
     * Requests that the file or directory denoted by this abstract pathname
     * be deleted when php terminates.  Deletion will be attempted only for
     * normal termination of php and if and if only System::shutdown() is
     * called.
     *
     * Once deletion has been requested, it is not possible to cancel the
     * request.  This method should therefore be used with care.
     *
     */
    public function deleteOnExit() {

        self::$fs->deleteOnExit($this);
    }

    /**
     * Returns an array of strings naming the files and directories in the
     * directory denoted by this abstract pathname.
     *
     * If this abstract pathname does not denote a directory, then this
     * method returns null  Otherwise an array of strings is
     * returned, one for each file or directory in the directory.  Names
     * denoting the directory itself and the directory's parent directory are
     * not included in the result.  Each string is a file name rather than a
     * complete path.
     *
     * There is no guarantee that the name strings in the resulting array
     * will appear in any specific order; they are not, in particular,
     * guaranteed to appear in alphabetical order.
     *
     * @return  An array of strings naming the files and directories in the
     *          directory denoted by this abstract pathname.  The array will be
     *          empty if the directory is empty.  Returns null if
     *          this abstract pathname does not denote a directory, or if an
     *          I/O error occurs.
     *
     */
    public function listFilenames($filter = null) {

        return self::$fs->lister($this, $filter);
    }

    public function listFiles($filter = null) {
        $ss = $this->listFilenames($filter);
        if ($ss === null) {
            return null;
        }
        $n = count($ss);
        $fs = array();
        for ($i = 0; $i < $n; $i++) {
            $fs[$i] = new File($this->path, (string) $ss[$i]);
        }
        return $fs;
    }


    /**
     *
     * @param blaze\io\File|blaze\lang\String|string $file The File-Object or path of the child.
     * @param boolean $direct
     * @return boolean
     */
    public function isChildOf($file, $direct = false){
        if(!$file instanceof File)
            $file = new File(String::asNative($file));

        $parentPath = $file->getAbsolutePath();
        $childPath = $this->getAbsolutePath();

        $index = $childPath->indexOf($parentPath);
        if($index === -1)
            return false;
        if(!$direct)
            return $index === 0;
        return $childPath->substring($parentPath->length())->indexOf(DIRECTORY_SEPARATOR) < 0;
    }

    /**
     *
     * @param blaze\io\File|blaze\lang\String|string $file The File-Object or path of the parent.
     * @param boolean $direct
     * @return boolean
     */
    public function isParentOf($file, $direct = false){
        if(!$file instanceof File)
            $file = new File(String::asNative($file));

        return $file->isChildOf($this, $direct);
    }

    /**
     * Creates the directory named by this abstract pathname, including any
     * necessary but nonexistent parent directories.  Note that if this
     * operation fails it may have succeeded in creating some of the necessary
     * parent directories.
     *
     * @return  true if and only if the directory was created,
     *          along with all necessary parent directories; false
     *          otherwise
     * @throws  IOException
     */
    public function mkdirs($mode = 0755) {
        if ($this->exists()) {
            return false;
        }
        try {
            if ($this->mkdir($mode)) {
                return true;
            }
        } catch (IOException $ioe) {
            // IOException from mkdir() means that directory propbably didn't exist.
        }
        $parentFile = $this->getParentFile();
        return (($parentFile !== null) && ($parentFile->mkdirs($mode) && $this->mkdir($mode)));
    }

    /**
     * Creates the directory named by this abstract pathname.
     *
     * @return  true if and only if the directory was created; false otherwise
     * @throws  IOException
     */
    public function mkdir($mode = 0755) {


        if (self::$fs->checkAccess(new File($this->path), true) !== true) {
            throw new IOException("No write access to " . $this->getPath()->toNative());
        }
        return self::$fs->createDirectory($this, $mode);
    }

    /**
     * Renames the file denoted by this abstract pathname.
     *
     * @param   destFile  The new abstract pathname for the named file
     * @return  true if and only if the renaming succeeded; false otherwise
     */
    public function renameTo(File $destFile) {

        if (self::$fs->checkAccess($this) !== true) {
            throw new IOException("No write access to " . $this->getPath()->toNative());
        }
        return self::$fs->rename($this, $destFile);
    }

    /**
     * Simple-copies file denoted by this abstract pathname into another
     * File
     *
     * @param File $destFile  The new abstract pathname for the named file
     * @return true if and only if the renaming succeeded; false otherwise
     */
    public function copyTo(File $destFile) {


        if (self::$fs->checkAccess($this) !== true) {
            throw new IOException("No read access to " . $this->getPath()->toNative() . "\n");
        }

        if (self::$fs->checkAccess($destFile, true) !== true) {
            throw new IOException("File::copyTo() No write access to " . $destFile->getPath()->toNative());
        }
        return self::$fs->copy($this, $destFile);
    }

    /**
     * Sets the last-modified time of the file or directory named by this
     * abstract pathname.
     *
     * All platforms support file-modification times to the nearest second,
     * but some provide more precision.  The argument will be truncated to fit
     * the supported precision.  If the operation succeeds and no intervening
     * operations on the file take place, then the next invocation of the
     * lastModified method will return the (possibly truncated) time argument
     * that was passed to this method.
     *
     * @param  time  The new last-modified time, measured in milliseconds since
     *               the epoch (00:00:00 GMT, January 1, 1970)
     * @return true if and only if the operation succeeded; false otherwise
     */
    public function setLastModified($time) {
        $time = (int) $time;
        if ($time < 0) {
            throw new Exception("IllegalArgumentException, Negative $time\n");
        }


        return self::$fs->setLastModifiedTime($this, $time);
    }

    /**
     * Marks the file or directory named by this abstract pathname so that
     * only read operations are allowed.  After invoking this method the file
     * or directory is guaranteed not to change until it is either deleted or
     * marked to allow write access.  Whether or not a read-only file or
     * directory may be deleted depends upon the underlying system.
     *
     * @return true if and only if the operation succeeded; false otherwise
     */
    public function setReadOnly() {

        if (self::$fs->checkAccess($this, true) !== true) {
            // Error, no write access
            throw new IOException("No write access to " . $this->getPath()->toNative());
        }
        return self::$fs->setReadOnly($this);
    }


   /**
     * Sets the owner's or everybody's write permission for this abstract
     * pathname.
     *
     * @param boolean  writable
     *          If <code>true</code>, sets the access permission to allow write
     *          operations; if <code>false</code> to disallow write operations
     *
     * @param boolean  ownerOnly
     *          If <code>true</code>, the write permission applies only to the
     *          owner's write permission; otherwise, it applies to everybody.  If
     *          the underlying file system can not distinguish the owner's write
     *          permission from that of others, then the permission will apply to
     *          everybody, regardless of this value.
     *
     * @return boolean <code>true</code> if and only if the operation succeeded. The
     *          operation will fail if the user does not have permission to change
     *          the access permissions of this abstract pathname.
     */
    public function setWritable($writable, $ownerOnly = true) {
	return self::$fs->setPermission($this, FileSystem::ACCESS_WRITE, $writable, $ownerOnly);
    }

    /**
     * Sets the owner's or everybody's read permission for this abstract
     * pathname.
     *
     * @param boolean  readable
     *          If <code>true</code>, sets the access permission to allow read
     *          operations; if <code>false</code> to disallow read operations
     *
     * @param boolean  ownerOnly
     *          If <code>true</code>, the read permission applies only to the
     *          owner's read permission; otherwise, it applies to everybody.  If
     *          the underlying file system can not distinguish the owner's read
     *          permission from that of others, then the permission will apply to
     *          everybody, regardless of this value.
     *
     * @return boolean <code>true</code> if and only if the operation succeeded.  The
     *          operation will fail if the user does not have permission to
     *          change the access permissions of this abstract pathname.  If
     *          <code>readable</code> is <code>false</code> and the underlying
     *          file system does not implement a read permission, then the
     *          operation will fail.
     */
    public function setReadable($readable, $ownerOnly = true) {
	return self::$fs->setPermission($this, FileSystem::ACCESS_READ, $readable, $ownerOnly);
    }

    /**
     * Sets the owner's or everybody's execute permission for this abstract
     * pathname.
     *
     * @param boolean  executable
     *          If <code>true</code>, sets the access permission to allow execute
     *          operations; if <code>false</code> to disallow execute operations
     *
     * @param boolean  ownerOnly
     *          If <code>true</code>, the execute permission applies only to the
     *          owner's execute permission; otherwise, it applies to everybody.
     *          If the underlying file system can not distinguish the owner's
     *          execute permission from that of others, then the permission will
     *          apply to everybody, regardless of this value.
     *
     * @return boolean <code>true</code> if and only if the operation succeeded.  The
     *          operation will fail if the user does not have permission to
     *          change the access permissions of this abstract pathname.  If
     *          <code>executable</code> is <code>false</code> and the underlying
     *          file system does not implement an execute permission, then the
     *          operation will fail.
     */
    public function setExecutable($executable, $ownerOnly = true) {
	return self::$fs->setPermission($this, FileSystem::ACCESS_EXECUTE, $executable, $ownerOnly);
    }

    /**
     * Sets the owner of the file.
     * @param mixed $user User name or number.
     */
    public function setUser($user) {

        return self::$fs->chown($this->getPath()->toNative(), $user);
    }

    /**
     * Retrieve the owner of this file.
     * @return int User ID of the owner of this file.
     */
    public function getUser() {
        return @fileowner($this->getPath()->toNative());
    }

    /**
     * Sets the group of the file.
     * @param mixed $user User name or number.
     */
    public function setGroup($group) {

        return self::$fs->chgrp($this->getPath()->toNative(), $group);
    }

    /**
     * Retrieve the group of this file.
     * @return int User ID of the owner of this file.
     */
    public function getGroup() {
        return @filegroup($this->getPath()->toNative());
    }

    /**
     * Sets the mode of the file
     * @param int $mode Ocatal mode.
     */
    public function setMode($mode) {

        return self::$fs->chmod($this->getPath()->toNative(), $mode);
    }

    /**
     * Retrieve the mode of this file.
     * @return int
     */
    public function getMode() {
        return @fileperms($this->getPath()->toNative());
    }

    /* -- Filesystem interface -- */

    /**
     * List the available filesystem roots.
     *
     * A particular platform may support zero or more hierarchically-organized
     * file systems.  Each file system has a root  directory from which all
     * other files in that file system can be reached.
     * Windows platforms, for example, have a root directory for each active
     * drive; UNIX platforms have a single root directory, namely "/".
     * The set of available filesystem roots is affected by various system-level
     * operations such the insertion or ejection of removable media and the
     * disconnecting or unmounting of physical or virtual disk drives.
     *
     * This method returns an array of File objects that
     * denote the root directories of the available filesystem roots.  It is
     * guaranteed that the canonical pathname of any file physically present on
     * the local machine will begin with one of the roots returned by this
     * method.
     *
     * The canonical pathname of a file that resides on some other machine
     * and is accessed via a remote-filesystem protocol such as SMB or NFS may
     * or may not begin with one of the roots returned by this method.  If the
     * pathname of a remote file is syntactically indistinguishable from the
     * pathname of a local file then it will begin with one of the roots
     * returned by this method.  Thus, for example, File objects
     * denoting the root directories of the mapped network drives of a Windows
     * platform will be returned by this method, while File
     * objects containing UNC pathnames will not be returned by this method.
     *
     * @return  An array of File objects denoting the available
     *          filesystem roots, or null if the set of roots
     *          could not be determined.  The array will be empty if there are
     *          no filesystem roots.
     */
    public function listRoots() {

        return (array) self::$fs->listRoots();
    }

     /* -- Disk usage -- */

    /**
     * Returns the size of the partition <a href="#partName">named</a> by this
     * abstract pathname.
     *
     * @return long The size, in bytes, of the partition or <tt>0L</tt> if this
     *          abstract pathname does not name a partition
     */
    public function getTotalSpace() {
	return self::$fs->getSpace($this,FileSystem::SPACE_TOTAL);
    }

    /**
     * Returns the number of unallocated bytes in the partition <a
     * href="#partName">named</a> by this abstract path name.
     *
     * <p> The returned number of unallocated bytes is a hint, but not
     * a guarantee, that it is possible to use most or any of these
     * bytes.  The number of unallocated bytes is most likely to be
     * accurate immediately after this call.  It is likely to be made
     * inaccurate by any external I/O operations including those made
     * on the system outside of this virtual machine.  This method
     * makes no guarantee that write operations to this file system
     * will succeed.
     *
     * @return long The number of unallocated bytes on the partition <tt>0L</tt>
     *          if the abstract pathname does not name a partition.  This
     *          value will be less than or equal to the total file system size
     *          returned by {@link #getTotalSpace}.
     */
    public function getFreeSpace() {
	return self::$fs->getFreeSpace($this,FileSystem::SPACE_FREE);
    }

    /**
     * Returns the number of bytes available to this virtual machine on the
     * partition <a href="#partName">named</a> by this abstract pathname.  When
     * possible, this method checks for write permissions and other operating
     * system restrictions and will therefore usually provide a more accurate
     * estimate of how much new data can actually be written than {@link
     * #getFreeSpace}.
     *
     * <p> The returned number of available bytes is a hint, but not a
     * guarantee, that it is possible to use most or any of these bytes.  The
     * number of unallocated bytes is most likely to be accurate immediately
     * after this call.  It is likely to be made inaccurate by any external
     * I/O operations including those made on the system outside of this
     * virtual machine.  This method makes no guarantee that write operations
     * to this file system will succeed.
     *
     * @return long The number of available bytes on the partition or <tt>0L</tt>
     *          if the abstract pathname does not name a partition.  On
     *          systems where this information is not available, this method
     *          will be equivalent to a call to {@link #getFreeSpace}.
     *
     */
    public function getUsableSpace() {
	return self::$fs->getUsableSpace($this,FileSystem::SPACE_USABLE);
    }

    /* -- Tempfile management -- */

    /**
     * Returns the path to the temp directory.
     */
    public function getTempDir() {
        return System::getProperty('php.tmpdir');
    }

    /**
     * Static method that creates a unique filename whose name begins with
     * $prefix and ends with $suffix in the directory $directory. $directory
     * is a reference to a File Object.
     * Then, the file is locked for exclusive reading/writing.
     *
     * @author      manuel holtgrewe, grin@gmx.net
     * @throws      IOException
     * @access      public
     */
    public function createTempFile($prefix, $suffix, File $directory) {

        // quick but efficient hack to create a unique filename ;-)
        $result = null;
        do {
            $result = new File($directory, $prefix . substr(md5(time()), 0, 8) . $suffix);
        } while (file_exists($result->getPath()->toNative()));


        self::$fs->createNewFile($result->getPath()->toNative());
        self::$fs->lock($result);

        return $result;
    }

    /**
     * If necessary, $File the lock on $File is removed and then the file is
     * deleted
     *
     * @access      public
     */
    public function removeTempFile() {

        // catch IO Exception
        self::$fs->unlock($this);
        $this->delete();
    }

    /* -- Basic infrastructure -- */

    /**
     * Compares two abstract pathnames lexicographically.  The ordering
     * defined by this method depends upon the underlying system.  On UNIX
     * systems, alphabetic case is significant in comparing pathnames; on Microsoft Windows
     * systems it is not.
     *
     * @param   pathname  The abstract pathname to be compared to this abstract
     *                    pathname
     *
     * @return int Zero if the argument is equal to this abstract pathname, a
     * 		value less than zero if this abstract pathname is
     * 		lexicographically less than the argument, or a value greater
     * 		than zero if this abstract pathname is lexicographically
     * 		greater than the argument
     *
     * @since   1.2
     */
    public function compareTo(Object $file) {
        if (!$file instanceof File)
            throw new ClassCastException();
        return self::$fs->compare($this, $file);
    }

    /**
     * Tests this abstract pathname for equality with the given object.
     * Returns <code>true</code> if and only if the argument is not
     * <code>null</code> and is an abstract pathname that denotes the same file
     * or directory as this abstract pathname.  Whether or not two abstract
     * pathnames are equal depends upon the underlying system.  On UNIX
     * systems, alphabetic case is significant in comparing pathnames; on Microsoft Windows
     * systems it is not.
     *
     * @param   obj   The object to be compared with this abstract pathname
     *
     * @return boolean  <code>true</code> if and only if the objects are the same;
     *                  <code>false</code> otherwise
     */
    public function equals(\blaze\lang\Reflectable $obj) {
        if (($obj != null) && ($obj instanceof File)) {
            return $this->compareTo($obj) == 0;
        }
        return false;
    }

    /**
     * Computes a hash code for this abstract pathname.  Because equality of
     * abstract pathnames is inherently system-dependent, so is the computation
     * of their hash codes.  On UNIX systems, the hash code of an abstract
     * pathname is equal to the exclusive <em>or</em> of the hash code
     * of its pathname string and the decimal value
     * <code>1234321</code>.  On Microsoft Windows systems, the hash
     * code is equal to the exclusive <em>or</em> of the hash code of
     * its pathname string converted to lower case and the decimal
     * value <code>1234321</code>.  Locale is not taken into account on
     * lowercasing the pathname string.
     *
     * @return string A hash code for this abstract pathname
     */
    public function hashCode() {
        return md5($this->getAbsolutePath()->toNative());
    }

    /**
     * Returns the pathname string of this abstract pathname.  This is just the
     * string returned by the <code>{@link #getPath}</code> method.
     *
     * @return string The string form of this abstract pathname
     */
    public function toString() {
        return $this->path->toNative();
    }

}
?>
