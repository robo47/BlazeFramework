<?php
namespace blaze\io;
use blaze\lang\Object,
    blaze\lang\String,
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
class File extends Object implements StaticInitialization, Serializable, Comparable{

    /**
     * The absolute path to the file which is represented by the object.
     * @var string The absolute path to the file.
     */
    private $path;

    private static $fs;
    public static $pathSeparator;
    public static $directorySeparator;

    public static function staticInit(){
        self::$fs = FileSystem::getInstance();
        self::$pathSeparator = self::$fs->getPathSeparator();
        self::$directorySeparator = self::$fs->getDirectorySeparator();
    }

    /**
     * Description of the constructor of File
     * @param blaze\io\File|string|blaze\lang\String $parent The parent File-object or a string which represents a path
     * @param string|blaze\lang\String $child The child pathname
     */
    public function __construct($parent, $child = null){
        if($parent instanceof File){
            if($parent->path === '')
		$parent = self::$fs->getDefaultParent();
	    else
		$parent = $parent->path;

            if($child === null){
		$this->path = self::$fs->normalize($parent);
	    } else {
		$this->path = self::$fs->resolve($parent,$child);
	    }
        }else if(is_string($parent) || $parent instanceof String){
            $parent = String::asNative($parent);
            
            if($child === null)
                $this->path = self::$fs->normalize($parent);
            else
                $this->path = self::$fs->resolve($parent,$child);
        }else{
            throw new IllegalArgumentException('The first parameter must be a File-object or a string');
        }

        if($this->path !== null)
            $this->path = String::asWrapper($this->path);
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
        return $this->path->substring($index + 1);
    }

    /**
     * Returns the pathname string of this abstract pathname's parent, or
     * <code>null</code> if this pathname does not name a parent directory.
     *
     * <p> The <em>parent</em> of an abstract pathname consists of the
     * pathname's prefix, if any, and each name in the pathname's name
     * sequence except for the last.  If the name sequence is empty then
     * the pathname does not name a parent directory.
     *
     * @return blaze\lang\String The pathname string of the parent directory named by this
     *          abstract pathname, or <code>null</code> if this pathname
     *          does not name a parent
     */
    public function getParent() {
	$index = $this->path->lastIndexOf(self::$separatorChar);
	return $this->path->substring(0, $index);
    }

    /**
     * Returns the abstract pathname of this abstract pathname's parent,
     * or <code>null</code> if this pathname does not name a parent
     * directory.
     *
     * <p> The <em>parent</em> of an abstract pathname consists of the
     * pathname's prefix, if any, and each name in the pathname's name
     * sequence except for the last.  If the name sequence is empty then
     * the pathname does not name a parent directory.
     *
     * @return blaze\io\File The abstract pathname of the parent directory named by this
     *          abstract pathname, or <code>null</code> if this pathname
     *          does not name a parent
     *
     * @since 1.2
     */
    public function getParentFile() {
	$p = $this->getParent();
	if ($p == null) return null;
	return new File($p);
    }

    /**
     * Converts this abstract pathname into a pathname string.  The resulting
     * string uses the {@link #separator default name-separator character} to
     * separate the names in the name sequence.
     *
     * @return blaze\lang\String The string form of this abstract pathname
     */
    public function getPath() {
	return $this->path;
    }


    /* -- Path operations -- */

    /**
     * Tests whether this abstract pathname is absolute.  The definition of
     * absolute pathname is system dependent.  On UNIX systems, a pathname is
     * absolute if its prefix is <code>"/"</code>.  On Microsoft Windows systems, a
     * pathname is absolute if its prefix is a drive specifier followed by
     * <code>"\\"</code>, or if its prefix is <code>"\\\\"</code>.
     *
     * @return boolean <code>true</code> if this abstract pathname is absolute,
     *          <code>false</code> otherwise
     */
    public function isAbsolute() {
	return self::$fs->isAbsolute($this);
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
        $f = new File($file);
        return $f->isChildOf($this,$direct);
    }

    /**
     * Returns the absolute pathname string of this abstract pathname.
     *
     * <p> If this abstract pathname is already absolute, then the pathname
     * string is simply returned as if by the <code>{@link #getPath}</code>
     * method.  If this abstract pathname is the empty abstract pathname then
     * the pathname string of the current user directory, which is named by the
     * system property <code>user.dir</code>, is returned.  Otherwise this
     * pathname is resolved in a system-dependent way.  On UNIX systems, a
     * relative pathname is made absolute by resolving it against the current
     * user directory.  On Microsoft Windows systems, a relative pathname is made absolute
     * by resolving it against the current directory of the drive named by the
     * pathname, if any; if not, it is resolved against the current user
     * directory.
     *
     * @return blaze\lang\String The absolute pathname string denoting the same file or
     *          directory as this abstract pathname
     *
     * @throws  SecurityException
     *          If a required system property value cannot be accessed.
     *
     * @see     java.io.File#isAbsolute()
     */
    public function getAbsolutePath() {
	return new String(self::$fs->resolve($this->path));
    }

    /**
     * Returns the absolute form of this abstract pathname.  Equivalent to
     * <code>new&nbsp;File(this.{@link #getAbsolutePath})</code>.
     *
     * @return blaze\io\File The absolute abstract pathname denoting the same file or
     *          directory as this abstract pathname
     *
     * @throws  SecurityException
     *          If a required system property value cannot be accessed.
     *
     * @since 1.2
     */
    public function getAbsoluteFile() {
        $absPath = $this->getAbsolutePath();
	return new File($absPath);
    }

    /**
     * Returns the canonical pathname string of this abstract pathname.
     *
     * <p> A canonical pathname is both absolute and unique.  The precise
     * definition of canonical form is system-dependent.  This method first
     * converts this pathname to absolute form if necessary, as if by invoking the
     * {@link #getAbsolutePath} method, and then maps it to its unique form in a
     * system-dependent way.  This typically involves removing redundant names
     * such as <tt>"."</tt> and <tt>".."</tt> from the pathname, resolving
     * symbolic links (on UNIX platforms), and converting drive letters to a
     * standard case (on Microsoft Windows platforms).
     *
     * <p> Every pathname that denotes an existing file or directory has a
     * unique canonical form.  Every pathname that denotes a nonexistent file
     * or directory also has a unique canonical form.  The canonical form of
     * the pathname of a nonexistent file or directory may be different from
     * the canonical form of the same pathname after the file or directory is
     * created.  Similarly, the canonical form of the pathname of an existing
     * file or directory may be different from the canonical form of the same
     * pathname after the file or directory is deleted.
     *
     * @return blaze\lang\String The canonical pathname string denoting the same file or
     *          directory as this abstract pathname
     *
     * @throws  IOException
     *          If an I/O error occurs, which is possible because the
     *          construction of the canonical pathname may require
     *          filesystem queries
     *
     * @throws  SecurityException
     *          If a required system property value cannot be accessed, or
     *          if a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead}</code> method denies
     *          read access to the file
     *
     * @since   JDK1.1
     */
    public function getCanonicalPath(){
	return new String(self::$fs->canonicalize(self::$fs->resolve($this)));
    }

    /**
     * Returns the canonical form of this abstract pathname.  Equivalent to
     * <code>new&nbsp;File(this.{@link #getCanonicalPath})</code>.
     *
     * @return blaze\io\File The canonical pathname string denoting the same file or
     *          directory as this abstract pathname
     *
     * @throws  IOException
     *          If an I/O error occurs, which is possible because the
     *          construction of the canonical pathname may require
     *          filesystem queries
     *
     * @throws  SecurityException
     *          If a required system property value cannot be accessed, or
     *          if a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead}</code> method denies
     *          read access to the file
     *
     * @since 1.2
     */
    public function getCanonicalFile(){
        $canonPath = $this->getCanonicalPath();
	return new File($canonPath);
    }

//    private static function slashify(String path, boolean isDirectory) {
//	String p = path;
//	if (File.separatorChar != '/')
//	    p = p.replace(File.separatorChar, '/');
//	if (!p.startsWith("/"))
//	    p = "/" + p;
//	if (!p.endsWith("/") && isDirectory)
//	    p = p + "/";
//	return p;
//    }

    /**
     * Converts this abstract pathname into a <code>file:</code> URL.  The
     * exact form of the URL is system-dependent.  If it can be determined that
     * the file denoted by this abstract pathname is a directory, then the
     * resulting URL will end with a slash.
     *
     * @return  A URL object representing the equivalent file URL
     *
     * @throws  MalformedURLException
     *          If the path cannot be parsed as a URL
     *
     * @see     #toURI()
     * @see     java.net.URI
     * @see     java.net.URI#toURL()
     * @see     java.net.URL
     * @since   1.2
     *
     * @deprecated This method does not automatically escape characters that
     * are illegal in URLs.  It is recommended that new code convert an
     * abstract pathname into a URL by first converting it into a URI, via the
     * {@link #toURI() toURI} method, and then converting the URI into a URL
     * via the {@link java.net.URI#toURL() URI.toURL} method.
     */
//    public URL toURL() throws MalformedURLException {
//	return new URL("file", "", slashify(getAbsolutePath(), isDirectory()));
//    }

    /**
     * Constructs a <tt>file:</tt> URI that represents this abstract pathname.
     *
     * <p> The exact form of the URI is system-dependent.  If it can be
     * determined that the file denoted by this abstract pathname is a
     * directory, then the resulting URI will end with a slash.
     *
     * <p> For a given abstract pathname <i>f</i>, it is guaranteed that
     *
     * <blockquote><tt>
     * new {@link #File(java.net.URI) File}(</tt><i>&nbsp;f</i><tt>.toURI()).equals(</tt><i>&nbsp;f</i><tt>.{@link #getAbsoluteFile() getAbsoluteFile}())
     * </tt></blockquote>
     *
     * so long as the original abstract pathname, the URI, and the new abstract
     * pathname are all created in (possibly different invocations of) the same
     * Java virtual machine.  Due to the system-dependent nature of abstract
     * pathnames, however, this relationship typically does not hold when a
     * <tt>file:</tt> URI that is created in a virtual machine on one operating
     * system is converted into an abstract pathname in a virtual machine on a
     * different operating system.
     *
     * @return URI An absolute, hierarchical URI with a scheme equal to
     *          <tt>"file"</tt>, a path representing this abstract pathname,
     *          and undefined authority, query, and fragment components
     * @throws SecurityException If a required system property value cannot
     * be accessed.
     *
     * @see #File(java.net.URI)
     * @see java.net.URI
     * @see java.net.URI#toURL()
     * @since 1.4
     */
    public function toURI() {
	try {
	    $f = $this->getAbsoluteFile();
	    $sp = $this->slashify($f->getPath(), $f->isDirectory());
	    if ($sp->startsWith("//"))
		$sp = "//" + $sp;
	    return new URI("file", null, $sp, null);
	} catch (URISyntaxException $x) {
	    throw new Error($x);		// Can't happen
	}
    }


    /* -- Attribute accessors -- */

    /**
     * Tests whether the application can read the file denoted by this
     * abstract pathname.
     *
     * @return boolean <code>true</code> if and only if the file specified by this
     *          abstract pathname exists <em>and</em> can be read by the
     *          application; <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the file
     */
    public function canRead() {
	return self::$fs->checkAccess($this, FileSystem::ACCESS_READ);
    }

    /**
     * Tests whether the application can modify the file denoted by this
     * abstract pathname.
     *
     * @return boolean <code>true</code> if and only if the file system actually
     *          contains a file denoted by this abstract pathname <em>and</em>
     *          the application is allowed to write to the file;
     *          <code>false</code> otherwise.
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to the file
     */
    public function canWrite() {
	return self::$fs->checkAccess($this, FileSystem::ACCESS_WRITE);
    }

    /**
     * Tests whether the file or directory denoted by this abstract pathname
     * exists.
     *
     * @return boolean <code>true</code> if and only if the file or directory denoted
     *          by this abstract pathname exists; <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the file or directory
     */
    public function exists() {
	return self::$fs->fileExists($this);
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a
     * directory.
     *
     * @return boolean <code>true</code> if and only if the file denoted by this
     *          abstract pathname exists <em>and</em> is a directory;
     *          <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the file
     */
    public function isDirectory() {
	return self::$fs->isDirectory($this);
    }

    /**
     * Tests whether the file denoted by this abstract pathname is a normal
     * file.  A file is <em>normal</em> if it is not a directory and, in
     * addition, satisfies other system-dependent criteria.  Any non-directory
     * file created by a Java application is guaranteed to be a normal file.
     *
     * @return boolean <code>true</code> if and only if the file denoted by this
     *          abstract pathname exists <em>and</em> is a normal file;
     *          <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the file
     */
    public function isFile() {
	return self::$fs->isFile($this);
    }

    /**
     * Tests whether the file named by this abstract pathname is a hidden
     * file.  The exact definition of <em>hidden</em> is system-dependent.  On
     * UNIX systems, a file is considered to be hidden if its name begins with
     * a period character (<code>'.'</code>).  On Microsoft Windows systems, a file is
     * considered to be hidden if it has been marked as such in the filesystem.
     *
     * @return  <code>true</code> if and only if the file denoted by this
     *          abstract pathname is hidden according to the conventions of the
     *          underlying platform
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the file
     *
     * @since 1.2
     */
    public function isHidden() {
	return false;//((fs.getBooleanAttributes(this) & FileSystem.BA_HIDDEN) != 0);
    }

    /**
     * Returns the time that the file denoted by this abstract pathname was
     * last modified.
     *
     * @return long A <code>long</code> value representing the time the file was
     *          last modified, measured in milliseconds since the epoch
     *          (00:00:00 GMT, January 1, 1970), or <code>0L</code> if the
     *          file does not exist or if an I/O error occurs
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the file
     */
    public function lastModified() {
	return self::$fs->getLastModifiedTime($this);
    }

    /**
     * Returns the length of the file denoted by this abstract pathname.
     * The return value is unspecified if this pathname denotes a directory.
     *
     * @return long The length, in bytes, of the file denoted by this abstract
     *          pathname, or <code>0L</code> if the file does not exist.  Some
     *          operating systems may return <code>0L</code> for pathnames
     *          denoting system-dependent entities such as devices or pipes.
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the file
     */
    public function length() {
	return self::$fs->getLength($this);
    }


    /* -- File operations -- */

    /**
     * Atomically creates a new, empty file named by this abstract pathname if
     * and only if a file with this name does not yet exist.  The check for the
     * existence of the file and the creation of the file if it does not exist
     * are a single operation that is atomic with respect to all other
     * filesystem activities that might affect the file.
     * <P>
     * Note: this method should <i>not</i> be used for file-locking, as
     * the resulting protocol cannot be made to work reliably. The
     * {@link java.nio.channels.FileLock FileLock}
     * facility should be used instead.
     *
     * @return boolean <code>true</code> if the named file does not exist and was
     *          successfully created; <code>false</code> if the named file
     *          already exists
     *
     * @throws  IOException
     *          If an I/O error occurred
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to the file
     *
     * @since 1.2
     */
    public function createNewFile() {
	return self::$fs->createFileExclusively($this->path);
    }

    /**
     * Deletes the file or directory denoted by this abstract pathname.  If
     * this pathname denotes a directory, then the directory must be empty in
     * order to be deleted.
     *
     * @return boolean <code>true</code> if and only if the file or directory is
     *          successfully deleted; <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkDelete}</code> method denies
     *          delete access to the file
     */
    public function delete() {
	return self::$fs->delete($this);
    }

    /**
     * Requests that the file or directory denoted by this abstract
     * pathname be deleted when the virtual machine terminates.
     * Files (or directories) are deleted in the reverse order that
     * they are registered. Invoking this method to delete a file or
     * directory that is already registered for deletion has no effect.
     * Deletion will be attempted only for normal termination of the
     * virtual machine, as defined by the Java Language Specification.
     *
     * <p> Once deletion has been requested, it is not possible to cancel the
     * request.  This method should therefore be used with care.
     *
     * <P>
     * Note: this method should <i>not</i> be used for file-locking, as
     * the resulting protocol cannot be made to work reliably. The
     * {@link java.nio.channels.FileLock FileLock}
     * facility should be used instead.
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkDelete}</code> method denies
     *          delete access to the file
     *
     * @see #delete
     *
     * @since 1.2
     * @todo Class DeleteOnExitHook must be implemented
     */
    public function deleteOnExit() {
	DeleteOnExitHook::add($path);
    }

    /**
     * Returns an array of strings naming the files and directories in the
     * directory denoted by this abstract pathname that satisfy the specified
     * filter.  The behavior of this method is the same as that of the
     * <code>{@link #list()}</code> method, except that the strings in the
     * returned array must satisfy the filter.  If the given
     * <code>filter</code> is <code>null</code> then all names are accepted.
     * Otherwise, a name satisfies the filter if and only if the value
     * <code>true</code> results when the <code>{@link
     * FilenameFilter#accept}</code> method of the filter is invoked on this
     * abstract pathname and the name of a file or directory in the directory
     * that it denotes.
     *
     * @param  filter  A filename filter
     *
     * @return array[blaze\lang\String] An array of strings naming the files and directories in the
     *          directory denoted by this abstract pathname that were accepted
     *          by the given <code>filter</code>.  The array will be empty if
     *          the directory is empty or if no names were accepted by the
     *          filter.  Returns <code>null</code> if this abstract pathname
     *          does not denote a directory, or if an I/O error occurs.
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the directory
     */
    public function listFilenames(FilenameFilter $filter = null) {
//	String names[] = list();
//	if ((names == null) || (filter == null)) {
//	    return names;
//	}
//	ArrayList v = new ArrayList();
//	for (int i = 0 ; i < names.length ; i++) {
//	    if (filter.accept(this, names[i])) {
//		v.add(names[i]);
//	    }
//	}
//	return (String[])(v.toArray(new String[v.size()]));
//
//      return self::$fs->listFiles($this);
    }

    /**
     * Returns an array of abstract pathnames denoting the files and
     * directories in the directory denoted by this abstract pathname that
     * satisfy the specified filter.  The behavior of this method is the
     * same as that of the <code>{@link #listFiles()}</code> method, except
     * that the pathnames in the returned array must satisfy the filter.
     * If the given <code>filter</code> is <code>null</code> then all
     * pathnames are accepted.  Otherwise, a pathname satisfies the filter
     * if and only if the value <code>true</code> results when the
     * <code>{@link FileFilter#accept(java.io.File)}</code> method of
     * the filter is invoked on the pathname.
     *
     * @param  filter  A file filter
     *
     * @return array[blaze\lang\File] An array of abstract pathnames denoting the files and
     *          directories in the directory denoted by this abstract
     *          pathname.  The array will be empty if the directory is
     *          empty.  Returns <code>null</code> if this abstract pathname
     *          does not denote a directory, or if an I/O error occurs.
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method denies read access to the directory
     *
     * @since 1.2
     */
    public function listFiles(FileFilter $filter = null) {
        /**
         * @var array[string]
         */
	$ss = $this->listFiles();
	if ($ss == null) return null;
	$v = new ArrayList();
	for ($i = 0 ; $i < $ss->length ; $i++) {
	    $f = new File($ss[$i], $this);
	    if (($filter == null) || $filter->accept($f)) {
		$v->add($f);
	    }
	}
	return $v->toArray();
    }

    /**
     * Creates the directory named by this abstract pathname.
     *
     * @return boolean <code>true</code> if and only if the directory was
     *          created; <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method does not permit the named directory to be created
     */
    public function mkdir() {
	return self::$fs->createDirectory($this);
    }

    /**
     * Creates the directory named by this abstract pathname, including any
     * necessary but nonexistent parent directories.  Note that if this
     * operation fails it may have succeeded in creating some of the necessary
     * parent directories.
     *
     * @return boolean <code>true</code> if and only if the directory was created,
     *          along with all necessary parent directories; <code>false</code>
     *          otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkRead(java.lang.String)}</code>
     *          method does not permit verification of the existence of the
     *          named directory and all necessary parent directories; or if
     *          the <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method does not permit the named directory and all necessary
     *          parent directories to be created
     */
    public function mkdirs() {
	if ($this->exists()) {
	    return false;
	}
	if ($this->mkdir()) {
 	    return true;
 	}
        $canonFile = null;
        try {
            $canonFile = $this->getCanonicalFile();
        } catch (IOException $e) {
            return false;
        }

	$parent = $canonFile->getParentFile();
	return ($parent != null && ($parent->mkdirs() || $parent->exists()) &&
		$canonFile->mkdir());
    }

    /**
     * Renames the file denoted by this abstract pathname.
     *
     * <p> Many aspects of the behavior of this method are inherently
     * platform-dependent: The rename operation might not be able to move a
     * file from one filesystem to another, it might not be atomic, and it
     * might not succeed if a file with the destination abstract pathname
     * already exists.  The return value should always be checked to make sure
     * that the rename operation was successful.
     *
     * @param  dest  The new abstract pathname for the named file
     *
     * @return boolean <code>true</code> if and only if the renaming succeeded;
     *          <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to either the old or new pathnames
     *
     * @throws  NullPointerException
     *          If parameter <code>dest</code> is <code>null</code>
     */
    public function renameTo(File $dest) {
	return self::$fs->rename($this, $dest);
    }

    /**
     * Sets the last-modified time of the file or directory named by this
     * abstract pathname.
     *
     * <p> All platforms support file-modification times to the nearest second,
     * but some provide more precision.  The argument will be truncated to fit
     * the supported precision.  If the operation succeeds and no intervening
     * operations on the file take place, then the next invocation of the
     * <code>{@link #lastModified}</code> method will return the (possibly
     * truncated) <code>time</code> argument that was passed to this method.
     *
     * @param long $time The new last-modified time, measured in milliseconds since
     *               the epoch (00:00:00 GMT, January 1, 1970)
     *
     * @return boolean <code>true</code> if and only if the operation succeeded;
     *          <code>false</code> otherwise
     *
     * @throws  IllegalArgumentException  If the argument is negative
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to the named file
     *
     * @since 1.2
     */
    public function setLastModified($time) {
	if ($time < 0) throw new IllegalArgumentException("Negative time");
	return self::$fs->setLastModifiedTime($this, $time);
    }

    /**
     * Marks the file or directory named by this abstract pathname so that
     * only read operations are allowed.  After invoking this method the file
     * or directory is guaranteed not to change until it is either deleted or
     * marked to allow write access.  Whether or not a read-only file or
     * directory may be deleted depends upon the underlying system.
     *
     * @return boolean <code>true</code> if and only if the operation succeeded;
     *          <code>false</code> otherwise
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to the named file
     *
     * @since 1.2
     */
    public function setReadOnly() {
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
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to the named file
     *
     * @since 1.6
     */
    public function setWritable($writable, $ownerOnly = true) {
	return self::$fs->setPermission($this, FileSystem.ACCESS_WRITE, $writable, $ownerOnly);
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
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to the file
     *
     * @since 1.6
     */
    public function setReadable($readable, $ownerOnly = true) {
	return self::$fs->setPermission($this, FileSystem.ACCESS_READ, $readable, $ownerOnly);
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
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method denies write access to the file
     *
     * @since 1.6
     */
    public function setExecutable($executable, $ownerOnly = true) {
	return self::$fs->setPermission($this, FileSystem.ACCESS_EXECUTE, $executable, $ownerOnly);
    }

    /**
     * Tests whether the application can execute the file denoted by this
     * abstract pathname.
     *
     * @return boolean <code>true</code> if and only if the abstract pathname exists
     *          <em>and</em> the application is allowed to execute the file
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkExec(java.lang.String)}</code>
     *          method denies execute access to the file
     *
     * @since 1.6
     */
    public function canExecute() {
	return self::$fs->checkAccess($this, FileSystem::ACCESS_EXECUTE);
    }


    /* -- Filesystem interface -- */

    /**
     * List the available filesystem roots.
     *
     * <p> A particular Java platform may support zero or more
     * hierarchically-organized file systems.  Each file system has a
     * <code>root</code> directory from which all other files in that file
     * system can be reached.  Windows platforms, for example, have a root
     * directory for each active drive; UNIX platforms have a single root
     * directory, namely <code>"/"</code>.  The set of available filesystem
     * roots is affected by various system-level operations such as the insertion
     * or ejection of removable media and the disconnecting or unmounting of
     * physical or virtual disk drives.
     *
     * <p> This method returns an array of <code>File</code> objects that
     * denote the root directories of the available filesystem roots.  It is
     * guaranteed that the canonical pathname of any file physically present on
     * the local machine will begin with one of the roots returned by this
     * method.
     *
     * <p> The canonical pathname of a file that resides on some other machine
     * and is accessed via a remote-filesystem protocol such as SMB or NFS may
     * or may not begin with one of the roots returned by this method.  If the
     * pathname of a remote file is syntactically indistinguishable from the
     * pathname of a local file then it will begin with one of the roots
     * returned by this method.  Thus, for example, <code>File</code> objects
     * denoting the root directories of the mapped network drives of a Windows
     * platform will be returned by this method, while <code>File</code>
     * objects containing UNC pathnames will not be returned by this method.
     *
     * <p> Unlike most methods in this class, this method does not throw
     * security exceptions.  If a security manager exists and its <code>{@link
     * java.lang.SecurityManager#checkRead(java.lang.String)}</code> method
     * denies read access to a particular root directory, then that directory
     * will not appear in the result.
     *
     * @return array[blaze\io\File] An array of <code>File</code> objects denoting the available
     *          filesystem roots, or <code>null</code> if the set of roots
     *          could not be determined.  The array will be empty if there are
     *          no filesystem roots.
     *
     * @since 1.2
     */
    public static function listRoots() {
	return self::$fs->listRoots();
    }


    /* -- Disk usage -- */

    /**
     * Returns the size of the partition <a href="#partName">named</a> by this
     * abstract pathname.
     *
     * @return long The size, in bytes, of the partition or <tt>0L</tt> if this
     *          abstract pathname does not name a partition
     *
     * @throws  SecurityException
     *          If a security manager has been installed and it denies
     *          {@link RuntimePermission}<tt>("getFileSystemAttributes")</tt>
     *          or its {@link SecurityManager#checkRead(String)} method denies
     *          read access to the file named by this abstract pathname
     *
     * @since  1.6
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
     *
     * @throws  SecurityException
     *          If a security manager has been installed and it denies
     *          {@link RuntimePermission}<tt>("getFileSystemAttributes")</tt>
     *          or its {@link SecurityManager#checkRead(String)} method denies
     *          read access to the file named by this abstract pathname
     *
     * @since  1.6
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
     * @throws  SecurityException
     *          If a security manager has been installed and it denies
     *          {@link RuntimePermission}<tt>("getFileSystemAttributes")</tt>
     *          or its {@link SecurityManager#checkRead(String)} method denies
     *          read access to the file named by this abstract pathname
     *
     * @since  1.6
     */
    public function getUsableSpace() {
	return self::$fs->getUsableSpace($this,FileSystem::SPACE_USABLE);
    }


    /* -- Temporary files -- */

    //private static final Object tmpFileLock = new Object();

    /**
     * @var integer
     */
    private static $counter = -1; /* Protected by tmpFileLock */

    /**
     * @param string $prefix
     * @param string $suffix
     * @param blaze\lang\File $dir
     * @return blaze\lang\File
     */

    private static function generateFile($prefix, $suffix, File $dir)
	//throws IOException
    {
	if ($counter == -1) {
            $r = new Random();
	    $counter = $r->nextInt() & 0xffff;
	}
	$counter++;
	return new File($dir, $prefix . $counter . $suffix);
    }

    private static $tmpdir;

    /**
     * @return string
     */

    private static function getTempDir() {
	if (self::$tmpdir == null) {
            self::$tmpdir = self::$fs->normalize(sys_get_temp_dir());
	}
	return self::$tmpdir;
    }

    /**
     * @return boolean
     */

//    private static boolean checkAndCreate(String filename, SecurityManager sm)
//	throws IOException
//    {
//	if (sm != null) {
//	    try {
//		sm.checkWrite(filename);
//	    } catch (AccessControlException x) {
//		/* Throwing the original AccessControlException could disclose
//		   the location of the default temporary directory, so we
//		   re-throw a more innocuous SecurityException */
//		throw new SecurityException("Unable to create temporary file");
//	    }
//	}
//	return fs.createFileExclusively(filename);
//    }

    /**
     * <p> Creates a new empty file in the specified directory, using the
     * given prefix and suffix strings to generate its name.  If this method
     * returns successfully then it is guaranteed that:
     *
     * <ol>
     * <li> The file denoted by the returned abstract pathname did not exist
     *      before this method was invoked, and
     * <li> Neither this method nor any of its variants will return the same
     *      abstract pathname again in the current invocation of the virtual
     *      machine.
     * </ol>
     *
     * This method provides only part of a temporary-file facility.  To arrange
     * for a file created by this method to be deleted automatically, use the
     * <code>{@link #deleteOnExit}</code> method.
     *
     * <p> The <code>prefix</code> argument must be at least three characters
     * long.  It is recommended that the prefix be a short, meaningful string
     * such as <code>"hjb"</code> or <code>"mail"</code>.  The
     * <code>suffix</code> argument may be <code>null</code>, in which case the
     * suffix <code>".tmp"</code> will be used.
     *
     * <p> To create the new file, the prefix and the suffix may first be
     * adjusted to fit the limitations of the underlying platform.  If the
     * prefix is too long then it will be truncated, but its first three
     * characters will always be preserved.  If the suffix is too long then it
     * too will be truncated, but if it begins with a period character
     * (<code>'.'</code>) then the period and the first three characters
     * following it will always be preserved.  Once these adjustments have been
     * made the name of the new file will be generated by concatenating the
     * prefix, five or more internally-generated characters, and the suffix.
     *
     * <p> If the <code>directory</code> argument is <code>null</code> then the
     * system-dependent default temporary-file directory will be used.  The
     * default temporary-file directory is specified by the system property
     * <code>java.io.tmpdir</code>.  On UNIX systems the default value of this
     * property is typically <code>"/tmp"</code> or <code>"/var/tmp"</code>; on
     * Microsoft Windows systems it is typically <code>"C:\\WINNT\\TEMP"</code>.  A different
     * value may be given to this system property when the Java virtual machine
     * is invoked, but programmatic changes to this property are not guaranteed
     * to have any effect upon the temporary directory used by this method.
     *
     * @param  prefix     The prefix string to be used in generating the file's
     *                    name; must be at least three characters long
     *
     * @param  suffix     The suffix string to be used in generating the file's
     *                    name; may be <code>null</code>, in which case the
     *                    suffix <code>".tmp"</code> will be used
     *
     * @param  directory  The directory in which the file is to be created, or
     *                    <code>null</code> if the default temporary-file
     *                    directory is to be used
     *
     * @return blaze\lang\File An abstract pathname denoting a newly-created empty file
     *
     * @throws  IllegalArgumentException
     *          If the <code>prefix</code> argument contains fewer than three
     *          characters
     *
     * @throws  IOException  If a file could not be created
     *
     * @throws  SecurityException
     *          If a security manager exists and its <code>{@link
     *          java.lang.SecurityManager#checkWrite(java.lang.String)}</code>
     *          method does not allow a file to be created
     *
     * @since 1.2
     */
    public static function createTempFile($prefix, $suffix,
				      File $directory = null)
        //throws IOException
    {
//	if (prefix == null) throw new NullPointerException();
//	if (prefix.length() < 3)
//	    throw new IllegalArgumentException("Prefix string too short");
//	String s = (suffix == null) ? ".tmp" : suffix;
//	synchronized (tmpFileLock) {
//	    if (directory == null) {
//                String tmpDir = getTempDir();
//		directory = new File(tmpDir, fs.prefixLength(tmpDir));
//	    }
//	    SecurityManager sm = System.getSecurityManager();
//	    File f;
//	    do {
//		f = generateFile(prefix, s, directory);
//	    } while (!checkAndCreate(f.getPath(), sm));
//	    return f;
//	}
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
     * @return integer Zero if the argument is equal to this abstract pathname, a
     *		value less than zero if this abstract pathname is
     *		lexicographically less than the argument, or a value greater
     *		than zero if this abstract pathname is lexicographically
     *		greater than the argument
     *
     * @since   1.2
     */
    public function compareTo(Object $pathname) {
        if(!$pathname instanceof File)
            throw new ClassCastException();
	return strcmp($this->path, $pathname);
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
	return md5($this->getAbsolutePath());
    }

    /**
     * Returns the pathname string of this abstract pathname.  This is just the
     * string returned by the <code>{@link #getPath}</code> method.
     *
     * @return string The string form of this abstract pathname
     */
    public function __toString() {
	return $this->path->toNative();
    }


    /**
     * WriteObject is called to save this filename.
     * The separator character is saved also so it can be replaced
     * in case the path is reconstituted on a different host type.
     * <p>
     * @serialData  Default fields followed by separator character.
     */
//    private synchronized void writeObject(java.io.ObjectOutputStream s)
//        throws IOException
//    {
//	s.defaultWriteObject();
//	s.writeChar(this.separatorChar); // Add the separator character
//    }

    /**
     * readObject is called to restore this filename.
     * The original separator character is read.  If it is different
     * than the separator character on this system, then the old separator
     * is replaced by the local separator.
     */
//    private synchronized void readObject(java.io.ObjectInputStream s)
//         throws IOException, ClassNotFoundException
//    {
//    }
}

?>
