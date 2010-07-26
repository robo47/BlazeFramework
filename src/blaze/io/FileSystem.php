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
class FileSystem extends Object implements Singleton{

    private static $instance;

    private $currentWorkingDirectory;
    private $regexSafeSeparator;

    /**
     * Description of the constructor of FileSystem
     *
     * @return FileSystem
     */
    private function __construct(){
        $this->currentWorkingDirectory = ClassLoader::getClassPath();
        $this->regexSafeSeparator = addslashes(preg_replace('/\//','\\/',DIRECTORY_SEPARATOR));
        chdir($this->currentWorkingDirectory->toNative());
    }

    /**
     *
     * @return FileSystem
     */
    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new FileSystem();
        return self::$instance;
    }

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
     *
     * @return string
     */
    public function normalize($path){
        return preg_replace('/[\/\\\]+/', DIRECTORY_SEPARATOR, String::asNative($path));
    }


    /**
     * Resolve the child pathname string against the parent.
     * Both strings must be in normal form, and the result
     * will be in normal form.
     *
     * @return string
     */
    public function resolve($parent, $child = null){
        $path = String::asNative($parent);
        if($child !== null)
            $path .= DIRECTORY_SEPARATOR.String::asNative($child);

        $res = preg_split('/'.$this->regexSafeSeparator.'/', $this->normalize($path));
        $arr = array();

        foreach($res as $entry){
            if($entry === '.'){}
            else if($entry === '..'){
                array_pop($arr);
            }else{
                $arr[] = $entry;
            }
        }
        return implode(DIRECTORY_SEPARATOR,$arr);
    }

    /**
     * Return the parent pathname string to be used when the parent-directory
     * argument in one of the two-argument File constructors is the empty
     * pathname.
     *
     * @return string
     */
    public function getDefaultParent(){
        return $this->currentWorkingDirectory;
    }

    /**
     * Post-process the given URI path string if necessary.  This is used on
     * win32, e.g., to transform "/c:/foo" into "c:/foo".  The path string
     * still has slash separators; code in the File class will translate them
     * after this method returns.
     *
     * @return string
     */
    public function fromURIPath($path){
        // @todo check java what it does when you make a File with URI
    }


    /* -- Path operations -- */

    /**
     * Tell whether or not the given abstract pathname is absolute.
     *
     * @return boolean
     */
    public function isAbsolute(File $f){
        return;
    }

    /**
     * @param string $path
     * @return string
     */
    public function canonicalize($path){// throws IOException
        return;
    }


    /* -- Attribute accessors -- */

    /* Constants for simple boolean attributes */
//    public static final int BA_EXISTS    = 0x01;
//    public static final int BA_REGULAR   = 0x02;
//    public static final int BA_DIRECTORY = 0x04;
//    public static final int BA_HIDDEN    = 0x08;

    /**
     * Return the simple boolean attributes for the file or directory denoted
     * by the given abstract pathname, or zero if it does not exist or some
     * other I/O error occurs.
     */
    public function getBooleanAttributes(File $f){
        
    }

    const ACCESS_READ    = 0x04;
    const ACCESS_WRITE   = 0x02;
    const ACCESS_EXECUTE = 0x01;

    /**
     * Check whether the file or directory denoted by the given abstract
     * pathname may be accessed by this process.  The second argument specifies
     * which access, ACCESS_READ, ACCESS_WRITE or ACCESS_EXECUTE, to check.
     * Return false if access is denied or an I/O error occurs
     *
     * @param integer $access
     * @return boolean
     */
    public function checkAccess(File $f, $access){
        $access = false;

        switch($access){
            case self::ACCESS_READ:
                $access = is_readable($f->getAbsolutePath());
                break;
            case self::ACCESS_WRITE:
                $access = is_writable($f->getAbsolutePath());
                break;
            case self::ACCESS_EXECUTE:
                $access = is_executable($f->getAbsolutePath());
                break;
            default:
                break;
        }
        return$access;
    }
    /**
     * Set on or off the access permission (to owner only or to all) to the file
     * or directory denoted by the given abstract pathname, based on the parameters
     * enable, access and oweronly.
     *
     * @param integer $access
     * @param boolean $enable
     * @param boolean $owneronly
     * @return boolean
     */
    public function setPermission(File $f, $access, $enable, $owneronly){
        return;
    }

    /**
     * Return the time at which the file or directory denoted by the given
     * abstract pathname was last modified, or zero if it does not exist or
     * some other I/O error occurs.
     *
     * @return long
     */
    public function getLastModifiedTime(File $f){
        return;
    }

    /**
     * Return the length in bytes of the file denoted by the given abstract
     * pathname, or zero if it does not exist, is a directory, or some other
     * I/O error occurs.
     *
     * @return long
     */
    public function getLength(File $f){
        return;
    }


    /**
     * Return the time at which the file or directory denoted by the given
     * abstract pathname was last modified, or zero if it does not exist or
     * some other I/O error occurs.
     *
     * @return long
     */
    public function fileExists(File $f){
        return file_exists($f->getAbsolutePath());
    }

    /* -- File operations -- */

    /**
     * Create a new empty file with the given pathname.  Return
     * <code>true</code> if the file was created and <code>false</code> if a
     * file or directory with the given pathname already exists.  Throw an
     * IOException if an I/O error occurs.
     *
     * @return boolean
     */
    public function createFileExclusively($pathname){
        return;
    }
	//throws IOException;

    /**
     * Delete the file or directory denoted by the given abstract pathname,
     * returning <code>true</code> if and only if the operation succeeds.
     *
     * @return delete
     */
    public function delete(File $f){
        return;
    }

    /**
     * List the elements of the directory denoted by the given abstract
     * pathname.  Return an array of strings naming the elements of the
     * directory if successful; otherwise, return <code>null</code>.
     *
     * @return array[string]
     */
    public function listFiles(File $f){
        return;
    }

    /**
     * Create a new directory denoted by the given abstract pathname,
     * returning <code>true</code> if and only if the operation succeeds.
     *
     * @return boolean
     */
    public function createDirectory(File $f){
        return;
    }

    /**
     * Rename the file or directory denoted by the first abstract pathname to
     * the second abstract pathname, returning <code>true</code> if and only if
     * the operation succeeds.
     *
     * @return boolean
     */
    public function rename(File $f1, File $f2){
        return;
    }

    /**
     * Set the last-modified time of the file or directory denoted by the
     * given abstract pathname, returning <code>true</code> if and only if the
     * operation succeeds.
     *
     * @return boolean
     */
    public function setLastModifiedTime(File $f, $time){
        return;
    }

    /**
     * Mark the file or directory denoted by the given abstract pathname as
     * read-only, returning <code>true</code> if and only if the operation
     * succeeds.
     *
     * @return boolean
     */
    public function setReadOnly(File $f){
        return;
    }


    /* -- Filesystem interface -- */

    /**
     * List the available filesystem roots.
     *
     * @return array[blaze\lang\File]
     */
    public function listRoots(){
        return;
    }

    const SPACE_TOTAL  = 0;
    const SPACE_FREE   = 1;
    const SPACE_USABLE = 2;

    /**
     * @throws blaze\io\IOException
     * @return long
     *
     */
    public function getSpace(File $f, $type){
        $space = false;

        switch($type){
            case self::SPACE_TOTAL:
                $space = disk_total_space($f->getAbsolutPath());
                break;
            case self::SPACE_USABLE:
            case self::SPACE_FREE:
                $space = disk_free_space($f->getAbsolutPath());
                break;
            default:
                break;
        }

        if($space === false)
            throw new IOExeption('Could not get the space of ' . $f->getAbsolutPath());
        return $space;
    }
}

?>
