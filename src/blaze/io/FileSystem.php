<?php
namespace blaze\io;
use blaze\lang\Object,
    blaze\lang\String,
    blaze\lang\Singleton,
    blaze\lang\ClassLoader;

/**
 * Description of FileSystem
 *
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     blaze\lang\ClassWrapper
 * @since   1.0
 * @version $Revision$
 * @author  Christian Beikov
 * @todo    Implementation and documentation.
 */
abstract class FileSystem extends Object implements Singleton{

    /* properties for simple boolean attributes */
    const BA_EXISTS    = 0x01;
    const BA_REGULAR   = 0x02;
    const BA_DIRECTORY = 0x04;
    const BA_HIDDEN    = 0x08;

    const ACCESS_READ    = 0x04;
    const ACCESS_WRITE   = 0x02;
    const ACCESS_EXECUTE = 0x01;

    const SPACE_TOTAL  = 0;
    const SPACE_FREE   = 1;
    const SPACE_USABLE = 2;

    private static $instance;

    private $currentWorkingDirectory;
    private $regexSafeSeparator;

    /**
     * Description of the constructor of FileSystem
     *
     * @return FileSystem
     */
    private function __construct(){
        $this->currentWorkingDirectory = getcwd();
        $this->regexSafeSeparator = addslashes(preg_replace('/\//','\\/',DIRECTORY_SEPARATOR));
    }

    /**
     *
     * @return FileSystem
     */
    public static function getInstance() {
        if(self::$instance === null){
            switch(String::asNative(\blaze\lang\System::getProperty('host.fs'))) {
                case 'UNIX':
                    self::$instance = new UnixFileSystem();
                break;
                case 'WIN32':
                    self::$instance = new Win32FileSystem();
                break;
                case 'WINNT':
                    self::$instance = new WinNTFileSystem();
                break;
                default:
                    throw new \blaze\lang\Exception('Host uses unsupported filesystem, unable to proceed');
            }
        }
        return self::$instance;
    }

    /* -- Normalization and construction -- */

    /**
     * Return the local filesystem's name-separator character.
     *
     * @return string
     */
    public function getDirectorySeparator(){
        return DIRECTORY_SEPARATOR;
    }

    /**
     * Return the local filesystem's path-separator character.
     *
     * @return string
     */
    public function getPathSeparator(){
        return PATH_SEPARATOR;
    }

    /**
     * Convert the given pathname string to normal form.  If the string is
     * already in normal form then it is simply returned.
     */
    public abstract function normalize($strPath);

    /**
     * Compute the length of this pathname string's prefix.  The pathname
     * string must be in normal form.
     */
    public abstract function prefixLength($pathname);

    /**
     * Resolve the child pathname string against the parent.
     * Both strings must be in normal form, and the result
     * will be a string in normal form.
     */
    public abstract function resolve($parent, $child);

    /**
     * Resolve the given abstract pathname into absolute form.  Invoked by the
     * getAbsolutePath and getCanonicalPath methods in the File class.
     */
    public abstract function resolveFile(File $f);

    /**
     * Return the parent pathname string to be used when the parent-directory
     * argument in one of the two-argument File constructors is the empty
     * pathname.
     */
    public abstract function getDefaultParent();
    
    public abstract function lister(File $f, $filter = null);

    /**
     * Post-process the given URI path string if necessary.  This is used on
     * win32, e.g., to transform "/c:/foo" into "c:/foo".  The path string
     * still has slash separators; code in the File class will translate them
     * after this method returns.
     */
    public abstract function fromURIPath($path);

    /* -- Path operations -- */

    /**
     * Tell whether or not the given abstract pathname is absolute.
     */
    public abstract function isAbsolute(File $f);

    /**
     * canonicalize filename by checking on disk
     * @return mixed Canonical path or false if the file doesn't exist.
     */
    public function canonicalize($strPath) {
        return @realpath($strPath);
    }

    /* -- Attribute accessors -- */

    /**
     * Return the simple boolean attributes for the file or directory denoted
     * by the given abstract pathname, or zero if it does not exist or some
     * other I/O error occurs.
     */
    public function getBooleanAttributes($f) {
        throw new Exception("SYSTEM ERROR method getBooleanAttributes() not implemented by fs driver");
    }

    /**
     * Check whether the file or directory denoted by the given abstract
     * pathname may be accessed by this process.  If the second argument is
     * false, then a check for read access is made; if the second
     * argument is true, then a check for write (not read-write)
     * access is made.  Return false if access is denied or an I/O error
     * occurs.
     */
    public function checkAccess(File $f, $access) {
        // we clear stat cache, its expensive to look up from scratch,
        // but we need to be sure
        @clearstatcache();


        // Shouldn't this be $f->GetAbsolutePath() ?
        // And why doesn't GetAbsolutePath() work?

        $strPath = $f->getPath()->toNative();

        // FIXME
        // if file object does denote a file that yet not existst
        // path rights are checked
        if (!@file_exists($strPath) && !is_dir($strPath)) {
            $strPath = $f->getParent()->toNative();
            if ($strPath === null || !is_dir($strPath)) {
                $strPath = System::getProperty("user.dir");
            }
            //$strPath = dirname($strPath);
        }

        $access = false;

        switch($access){
            case self::ACCESS_READ:
                $access = @is_readable($strPath);
                break;
            case self::ACCESS_WRITE:
                $access = @is_writable($strPath);
                break;
            case self::ACCESS_EXECUTE:
                $access = @is_executable($strPath);
                break;
            default:
                break;
        }
        return $access;
    }

    /**
     * Set on or off the access permission (to owner only or to all) to the file
     * or directory denoted by the given abstract pathname, based on the parameters
     * enable, access and oweronly.
     *
     * @param int $access
     * @param boolean $enable
     * @param boolean $owneronly
     * @return boolean
     */
    public function setPermission(File $f, $access, $enable, $owneronly){
        $mode  = $owneronly ? 'u' : 'a';
        $mode .= $enable ? '+' : '-';
        $mode .= $access && self::ACCESS_READ ? 'r' : '';
        $mode .= $access && self::ACCESS_WRITE ? 'w' : '';
        $mode .= $access && self::ACCESS_EXECUTE ? 'x' : '';
        $this->chmod($f->getAbsolutePath(), $mode);
    }

    /**
     * Whether file can be deleted.
     * @param File $f
     * @return boolean
     */
    public function canDelete(File $f)
    {
        clearstatcache();
        $dir = dirname($f->getAbsolutePath()->toNative());
        return (bool) @is_writable($dir);
    }

    /**
     * Return the time at which the file or directory denoted by the given
     * abstract pathname was last modified, or zero if it does not exist or
     * some other I/O error occurs.
     */
    public function getLastModifiedTime(File $f) {

        if (!$f->exists()) {
            return 0;
        }

        @clearstatcache();
        $strPath = $f->getPath()->toNative();
        $mtime = @filemtime($strPath);
        if (false === $mtime) {
            // FAILED. Log and return err.
            $msg = "FileSystem::Filemtime() FAILED. Cannot can not get modified time of $strPath. $php_errormsg";
            throw new Exception($msg);
        } else {
            return (int) $mtime;
        }
    }

    /**
     * Return the length in bytes of the file denoted by the given abstract
     * pathname, or zero if it does not exist, is a directory, or some other
     * I/O error occurs.
     */
    public function getLength(File $f) {
        $strPath = (string) $f->getAbsolutePath()->toNative();
        $fs = filesize((string) $strPath);
        if ($fs !== false) {
            return $fs;
        } else {
            $msg = "FileSystem::Read() FAILED. Cannot get filesize of $strPath. $php_errormsg";
            throw new Exception($msg);
        }
    }

    /* -- File operations -- */

    /**
     * Create a new empty file with the given pathname.  Return
     * true if the file was created and false if a
     * file or directory with the given pathname already exists.  Throw an
     * IOException if an I/O error occurs.
     *
     * @param       string      Path of the file to be created.
     *
     * @throws      IOException
     */
    public function createNewFile($strPathname) {
        if (@file_exists($strPathname))
            return false;

        // Create new file
        $fp = @fopen($strPathname, "w");
        if ($fp === false) {
            throw new IOException("The file \"$strPathname\" could not be created");
        }
        @fclose($fp);
        return true;
    }

    /**
     * Delete the file or directory denoted by the given abstract pathname,
     * returning true if and only if the operation succeeds.
     */
    public function delete(File $f, $recursive = false) {
        if ($f->isDirectory()) {
            return $this->rmdir($f->getPath()->toNative(), $recursive);
        } else {
            return $this->unlink($f->getPath()->toNative());
        }
    }

    /**
     * Arrange for the file or directory denoted by the given abstract
     * pathname to be deleted when System::shutdown is called, returning
    * true if and only if the operation succeeds.
     */
    public function deleteOnExit($f) {
        throw new Exception("deleteOnExit() not implemented by local fs driver");
    }

    /**
     * List the elements of the directory denoted by the given abstract
     * pathname.  Return an array of strings naming the elements of the
     * directory if successful; otherwise, return <code>null</code>.
     */
    public function listDir(File $f) {
        $strPath = (string) $f->getAbsolutePath()->toNative();
        $d = @dir($strPath);
        if (!$d) {
            return null;
        }
        $list = array();
        while($entry = $d->read()) {
            if ($entry != "." && $entry != "..") {
                array_push($list, $entry);
            }
        }
        $d->close();
        unset($d);
        return $list;
    }

    /**
     * Create a new directory denoted by the given abstract pathname,
     * returning true if and only if the operation succeeds.
     *
     * NOTE: umask() is reset to 0 while executing mkdir(), and restored afterwards
     */
    public function createDirectory(&$f, $mode = 0755) {
        $old_umask = umask(0);
        $return = @mkdir($f->getAbsolutePath()->toNative(), $mode);
        umask($old_umask);
        return $return;
    }

    /**
     * Rename the file or directory denoted by the first abstract pathname to
     * the second abstract pathname, returning true if and only if
     * the operation succeeds.
     *
     * @param File $f1 abstract source file
     * @param File $f2 abstract destination file
     * @return void
     * @throws Exception if rename cannot be performed
     */
    public function rename(File $f1, File $f2) {
        // get the canonical paths of the file to rename
        $src = $f1->getAbsolutePath()->toNative();
        $dest = $f2->getAbsolutePath()->toNative();
        if (false === @rename($src, $dest)) {
            $msg = "Rename FAILED. Cannot rename $src to $dest. $php_errormsg";
            throw new Exception($msg);
        }
    }

    /**
     * Set the last-modified time of the file or directory denoted by the
     * given abstract pathname returning true if and only if the
     * operation succeeds.
     * @return void
     * @throws Exception
     */
    public function setLastModifiedTime(File $f, $time) {
        $path = $f->getPath()->toNative();
        $success = @touch($path, $time);
        if (!$success) {
            throw new Exception("Could not touch '" . $path . "' due to: $php_errormsg");
        }
    }

    /**
     * Mark the file or directory denoted by the given abstract pathname as
     * read-only, returning <code>true</code> if and only if the operation
     * succeeds.
     */
    public function setReadOnly($f) {
        throw new Exception("setReadonle() not implemented by local fs driver");
    }

    /* -- Filesystem interface -- */

    /**
     * List the available filesystem roots, return array of File objects
     */
    public function listRoots() {
        throw new Exception("SYSTEM ERROR [listRoots() not implemented by local fs driver]");
    }

    /**
     * @throws blaze\io\IOException
     * @return long
     *
     */
    public function getSpace(File $f, $type){
        $space = false;

        switch($type){
            case self::SPACE_TOTAL:
                $space = disk_total_space($f->getAbsolutePath()->toNative());
                break;
            case self::SPACE_USABLE:
            case self::SPACE_FREE:
                $space = disk_free_space($f->getAbsolutePath()->toNative());
                break;
            default:
                break;
        }

        if($space === false)
            throw new IOExeption('Could not get the space of ' . $f->getAbsolutePath()->toNative());
        return $space;
    }

    /* -- Basic infrastructure -- */

    /**
     * Compare two abstract pathnames lexicographically.
     */
    public function compare($f1, $f2) {
        throw new Exception("SYSTEM ERROR [compare() not implemented by local fs driver]");
    }

    /**
     * Copy a file.
     *
     * @param File $src Source path and name file to copy.
     * @param File $dest Destination path and name of new file.
     *
     * @return void
     * @throws Exception if file cannot be copied.
     */
    public function copy(File $src, File $dest) {
        global $php_errormsg;

        // Recursively copy a directory
        if($src->isDirectory()) {
            return $this->copyr($src->getAbsolutePath()->toNative(), $dest->getAbsolutePath()->toNative());
        }

        $srcPath  = $src->getAbsolutePath()->toNative();
        $destPath = $dest->getAbsolutePath()->toNative();

        if (false === @copy($srcPath, $destPath)) { // Copy FAILED. Log and return err.
            // Add error from php to end of log message. $php_errormsg.
            $msg = "FileSystem::copy() FAILED. Cannot copy $srcPath to $destPath. $php_errormsg";
            throw new Exception($msg);
        }

        try {
            $dest->setMode($src->getMode());
        } catch(Exception $exc) {
            // [MA] does chmod returns an error on systems that do not support it ?
            // eat it up for now.
        }
    }

    /**
     * Copy a file, or recursively copy a folder and its contents
     *
     * @author      Aidan Lister <aidan@php.net>
     * @version     1.0.1
     * @link        http://aidanlister.com/repos/v/function.copyr.php
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @return      bool     Returns TRUE on success, FALSE on failure
     */
    public function copyr($source, $dest)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->copyr("$source/$entry", "$dest/$entry");
        }

        // Clean up
        $dir->close();
        return true;
    }

    /**
     * Change the ownership on a file or directory.
     *
     * @param    string $pathname Path and name of file or directory.
     * @param    string $user The user name or number of the file or directory. See http://us.php.net/chown
     *
     * @return void
     * @throws Exception if operation failed.
     */
    public function chown($pathname, $user) {
        if (false === @chown($pathname, $user)) {// FAILED.
            $msg = "FileSystem::chown() FAILED. Cannot chown $pathname. User $user." . (isset($php_errormsg) ? ' ' . $php_errormsg : "");
            throw new Exception($msg);
        }
    }

    /**
     * Change the group on a file or directory.
     *
     * @param    string $pathname Path and name of file or directory.
     * @param    string $group The group of the file or directory. See http://us.php.net/chgrp
     *
     * @return void
     * @throws Exception if operation failed.
     */
    public function chgrp($pathname, $group) {
        if (false === @chgrp($pathname, $group)) {// FAILED.
            $msg = "FileSystem::chgrp() FAILED. Cannot chown $pathname. Group $group." . (isset($php_errormsg) ? ' ' . $php_errormsg : "");
            throw new Exception($msg);
        }
    }

    /**
     * Change the permissions on a file or directory.
     *
     * @param    pathname    String. Path and name of file or directory.
     * @param    mode        Int. The mode (permissions) of the file or
     *                        directory. If using octal add leading 0. eg. 0777.
     *                        Mode is affected by the umask system setting.
     *
     * @return void
     * @throws Exception if operation failed.
     */
    public function chmod($pathname, $mode) {
        $str_mode = decoct($mode); // Show octal in messages.
        if (false === @chmod($pathname, $mode)) {// FAILED.
            $msg = "FileSystem::chmod() FAILED. Cannot chmod $pathname. Mode $str_mode." . (isset($php_errormsg) ? ' ' . $php_errormsg : "");
            throw new Exception($msg);
        }
    }

    /**
     * Locks a file and throws an Exception if this is not possible.
     * @return void
     * @throws Exception
     */
    public function lock(File $f) {
        $filename = $f->getPath()->toNative();
        $fp = @fopen($filename, "w");
        $result = @flock($fp, LOCK_EX);
        @fclose($fp);
        if (!$result) {
            throw new Exception("Could not lock file '$filename'");
        }
    }

    /**
     * Unlocks a file and throws an IO Error if this is not possible.
     *
     * @throws Exception
     * @return void
     */
    public function unlock(File $f) {
        $filename = $f->getPath()->toNative();
        $fp = @fopen($filename, "w");
        $result = @flock($fp, LOCK_UN);
        fclose($fp);
        if (!$result) {
            throw new Exception("Could not unlock file '$filename'");
        }
    }

    /**
     * Delete a file.
     *
     * @param    file    String. Path and/or name of file to delete.
     *
     * @return void
     * @throws Exception - if an error is encountered.
     */
    public function unlink($file) {
        global $php_errormsg;
        if (false === @unlink($file)) {
            $msg = "FileSystem::unlink() FAILED. Cannot unlink '$file'. $php_errormsg";
            throw new Exception($msg);
        }
    }

    /**
     * Symbolically link a file to another name.
     *
     * Currently symlink is not implemented on Windows. Don't use if the application is to be portable.
     *
     * @param string $target Path and/or name of file to link.
     * @param string $link Path and/or name of link to be created.
     * @return void
     */
    public function symlink($target, $link) {

        // If Windows OS then symlink() will report it is not supported in
        // the build. Use this error instead of checking for Windows as the OS.

        if (false === @symlink($target, $link)) {
            // Add error from php to end of log message. $php_errormsg.
            $msg = "FileSystem::Symlink() FAILED. Cannot symlink '$target' to '$link'. $php_errormsg";
            throw new Exception($msg);
        }

    }

    /**
     * Set the modification and access time on a file to the present time.
     *
     * @param string $file Path and/or name of file to touch.
     * @param int $time
     * @return void
     */
    public function touch($file, $time = null) {
        global $php_errormsg;

        if (null === $time) {
            $error = @touch($file);
        } else {
            $error = @touch($file, $time);
        }

        if (false === $error) { // FAILED.
            // Add error from php to end of log message. $php_errormsg.
            $msg = "FileSystem::touch() FAILED. Cannot touch '$file'. $php_errormsg";
            throw new Exception($msg);
        }
    }

    /**
     * Delete an empty directory OR a directory and all of its contents.
     *
     * @param    dir    String. Path and/or name of directory to delete.
     * @param    children    Boolean.    False: don't delete directory contents.
     *                                    True: delete directory contents.
     *
     * @return void
     */
    public function rmdir($dir, $children = false) {
        global $php_errormsg;

        // If children=FALSE only delete dir if empty.
        if (false === $children) {

            if (false === @rmdir($dir)) { // FAILED.
                // Add error from php to end of log message. $php_errormsg.
                $msg = "FileSystem::rmdir() FAILED. Cannot rmdir $dir. $php_errormsg";
                throw new Exception($msg);
            }

        } else { // delete contents and dir.

            $handle = @opendir($dir);

            if (false === $handle) { // Error.

                $msg = "FileSystem::rmdir() FAILED. Cannot opendir() $dir. $php_errormsg";
                throw new Exception($msg);

            } else { // Read from handle.

                // Don't error on readdir().
                while (false !== ($entry = @readdir($handle))) {

                    if ($entry != '.' && $entry != '..') {

                        // Only add / if it isn't already the last char.
                        // This ONLY serves the purpose of making the Logger
                        // output look nice:)

                        if (strpos(strrev($dir), DIRECTORY_SEPARATOR) === 0) {// there is a /
                            $next_entry = $dir . $entry;
                        } else { // no /
                            $next_entry = $dir . DIRECTORY_SEPARATOR . $entry;
                        }

                        // NOTE: As of php 4.1.1 is_dir doesn't return FALSE it
                        // returns 0. So use == not ===.

                        // Don't error on is_dir()
                        if (false == @is_dir($next_entry)) { // Is file.

                            try {
                                self::unlink($next_entry); // Delete.
                            } catch (Exception $e) {
                                $msg = "FileSystem::Rmdir() FAILED. Cannot FileSystem::Unlink() $next_entry. ". $e->getMessage();
                                throw new Exception($msg);
                            }

                        } else { // Is directory.

                            try {
                                self::rmdir($next_entry, true); // Delete
                            } catch (Exception $e) {
                                $msg = "FileSystem::rmdir() FAILED. Cannot FileSystem::rmdir() $next_entry. ". $e->getMessage();
                                throw new Exception($msg);
                            }

                        } // end is_dir else
                    } // end .. if
                } // end while
            } // end handle if

            // Don't error on closedir()
            @closedir($handle);

            if (false === @rmdir($dir)) { // FAILED.
                // Add error from php to end of log message. $php_errormsg.
                $msg = "FileSystem::rmdir() FAILED. Cannot rmdir $dir. $php_errormsg";
                throw new Exception($msg);
            }

        }

    }

    /**
     * Set the umask for file and directory creation.
     *
     * @param    mode    Int. Permissions ususally in ocatal. Use leading 0 for
     *                    octal. Number between 0 and 0777.
     *
     * @return void
     * @throws Exception if there is an error performing operation.
     */
    public function umask($mode) {
        global $php_errormsg;

        // CONSIDERME:
        // Throw a warning if mode is 0. PHP converts illegal octal numbers to
        // 0 so 0 might not be what the user intended.

        $str_mode = decoct($mode); // Show octal in messages.

        if (false === @umask($mode)) { // FAILED.
            // Add error from php to end of log message. $php_errormsg.
            $msg = "FileSystem::Umask() FAILED. Value $mode. $php_errormsg";
            throw new Exception($msg);
        }
    }

    /**
     * Compare the modified time of two files.
     *
     * @param    file1    String. Path and name of file1.
     * @param    file2    String. Path and name of file2.
     *
     * @return    Int.     1 if file1 is newer.
     *                 -1 if file2 is newer.
     *                  0 if files have the same time.
     *                  Err object on failure.
     *
     * @throws Exception - if cannot get modified time of either file.
     */
    public function compareMTimes($file1, $file2) {

        $mtime1 = filemtime($file1);
        $mtime2 = filemtime($file2);

        if ($mtime1 === false) { // FAILED. Log and return err.
            // Add error from php to end of log message. $php_errormsg.
            $msg = "FileSystem::compareMTimes() FAILED. Cannot can not get modified time of $file1.";
            throw new Exception($msg);
        } elseif ($mtime2 === false) { // FAILED. Log and return err.
            // Add error from php to end of log message. $php_errormsg.
            $msg = "FileSystem::compareMTimes() FAILED. Cannot can not get modified time of $file2.";
            throw new Exception($msg);
        } else { // Worked. Log and return compare.
            // Compare mtimes.
            if ($mtime1 == $mtime2) {
                return 0;
            } else {
                return ($mtime1 < $mtime2) ? -1 : 1;
            } // end compare
        }
    }

}

?>
