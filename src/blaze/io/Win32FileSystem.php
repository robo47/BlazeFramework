<?php

namespace blaze\io;
/**
 * Inpired by the File System API of Phing
 */
class Win32FileSystem extends FileSystem {

    protected $slash;
    protected $altSlash;
    protected $semicolon;
    private static $driveDirCache = array();

    public function __construct() {
        $this->slash = self::getDirectorySeparator();
        $this->semicolon = self::getPathSeparator();
        $this->altSlash = ($this->slash === '\\') ? '/' : '\\';
    }

    private function isSlash($c) {
        return ($c == '\\') || ($c == '/');
    }

    private function isLetter($c) {
        return ((ord($c) >= ord('a')) && (ord($c) <= ord('z')))
        || ((ord($c) >= ord('A')) && (ord($c) <= ord('Z')));
    }

    private function slashify($p) {
        if ((strlen($p) > 0) && ($p{0} != $this->slash)) {
            return $this->slash . $p;
        } else {
            return $p;
        }
    }

    /* -- Normalization and construction -- */

    public function getDirectorySeparator() {
        // the ascii value of is the \
        return chr(92);
    }

    public function getPathSeparator() {
        return ';';
    }

    /**
     * A normal Win32 pathname contains no duplicate slashes, except possibly
     * for a UNC prefix, and does not end with a slash.  It may be the empty
     * string.  Normalized Win32 pathnames have the convenient property that
     * the length of the prefix almost uniquely identifies the type of the path
     * and whether it is absolute or relative:
     *
     *    0  relative to both drive and directory
     *    1  drive-relative (begins with '\\')
     *    2  absolute UNC (if first char is '\\'), else directory-relative (has form "z:foo")
     *    3  absolute local pathname (begins with "z:\\")
     */
    private function normalizePrefix($strPath, $len, &$sb) {
        $src = 0;
        while (($src < $len) && $this->isSlash($strPath{$src})) {
            $src++;
        }
        $c = "";
        if (($len - $src >= 2)
                && $this->isLetter($c = $strPath{$src})
                && $strPath{$src + 1} === ':') {
            /* Remove leading slashes if followed by drive specifier.
             * This hack is necessary to support file URLs containing drive
             * specifiers (e.g., "file://c:/path").  As a side effect,
             * "/c:/path" can be used as an alternative to "c:/path". */
            $sb .= $c;
            $sb .= ':';
            $src += 2;
        } else {
            $src = 0;
            if (($len >= 2)
                    && $this->isSlash($strPath{0})
                    && $this->isSlash($strPath{1})) {
                /* UNC pathname: Retain first slash; leave src pointed at
                 * second slash so that further slashes will be collapsed
                 * into the second slash.  The result will be a pathname
                 * beginning with "\\\\" followed (most likely) by a host
                 * name. */
                $src = 1;
                $sb.=$this->slash;
            }
        }
        return $src;
    }

    /** Normalize the given pathname, whose length is len, starting at the given
      offset; everything before this offset is already normal. */
    protected function normalizer($strPath, $len, $offset) {
        if ($len == 0) {
            return $strPath;
        }
        if ($offset < 3) {
            $offset = 0;    //Avoid fencepost cases with UNC pathnames
        }
        $src = 0;
        $slash = $this->slash;
        $sb = "";

        if ($offset == 0) {
            // Complete normalization, including prefix
            $src = $this->normalizePrefix($strPath, $len, $sb);
        } else {
            // Partial normalization
            $src = $offset;
            $sb .= substr($strPath, 0, $offset);
        }

        // Remove redundant slashes from the remainder of the path, forcing all
        // slashes into the preferred slash
        while ($src < $len) {
            $c = $strPath{$src++};
            if ($this->isSlash($c)) {
                while (($src < $len) && $this->isSlash($strPath{$src})) {
                    $src++;
                }
                if ($src === $len) {
                    /* Check for trailing separator */
                    $sn = (int) strlen($sb);
                    if (($sn == 2) && ($sb{1} === ':')) {
                        // "z:\\"
                        $sb .= $slash;
                        break;
                    }
                    if ($sn === 0) {
                        // "\\"
                        $sb .= $slash;
                        break;
                    }
                    if (($sn === 1) && ($this->isSlash($sb{0}))) {
                        /* "\\\\" is not collapsed to "\\" because "\\\\" marks
                          the beginning of a UNC pathname.  Even though it is
                          not, by itself, a valid UNC pathname, we leave it as
                          is in order to be consistent with the win32 APIs,
                          which treat this case as an invalid UNC pathname
                          rather than as an alias for the root directory of
                          the current drive. */
                        $sb .= $slash;
                        break;
                    }
                    // Path does not denote a root directory, so do not append
                    // trailing slash
                    break;
                } else {
                    $sb .= $slash;
                }
            } else {
                $sb.=$c;
            }
        }
        $rv = (string) $sb;
        return $rv;
    }

    /**
     * Check that the given pathname is normal.  If not, invoke the real
     * normalizer on the part of the pathname that requires normalization.
     * This way we iterate through the whole pathname string only once.
     * @param string $strPath
     * @return string
     */
    public function normalize($strPath) {
        $strPath = (string) $strPath;
        $n = strlen($strPath);
        $slash = $this->slash;
        $altSlash = $this->altSlash;
        $prev = 0;
        for ($i = 0; $i < $n; $i++) {
            $c = $strPath{$i};
            if ($c === $altSlash) {
                return $this->normalizer($strPath, $n, ($prev === $slash) ? $i - 1 : $i);
            }
            if (($c === $slash) && ($prev === $slash) && ($i > 1)) {
                return $this->normalizer($strPath, $n, $i - 1);
            }
            if (($c === ':') && ($i > 1)) {
                return $this->normalizer($strPath, $n, 0);
            }
            $prev = $c;
        }
        if ($prev === $slash) {
            return $this->normalizer($strPath, $n, $n - 1);
        }
        return $strPath;
    }

    public function prefixLength($strPath) {
        $path = (string) $strPath;
        $slash = (string) $this->slash;
        $n = (int) strlen($path);
        if ($n === 0) {
            return 0;
        }
        $c0 = $path{0};
        $c1 = ($n > 1) ? $path{1} :
                0;
        if ($c0 === $slash) {
            if ($c1 === $slash) {
                return 2;            // absolute UNC pathname "\\\\foo"
            }
            return 1;                // drive-relative "\\foo"
        }

        if ($this->isLetter($c0) && ($c1 === ':')) {
            if (($n > 2) && ($path{2}) === $slash) {
                return 3;            // Absolute local pathname "z:\\foo" */
            }
            return 2;                // Directory-relative "z:foo"
        }
        return 0;                    // Completely relative
    }

    public function resolve($parent, $child) {
        $parent = (string) $parent;
        $child = (string) $child;
        $slash = (string) $this->slash;

        $pn = (int) strlen($parent);
        if ($pn === 0) {
            return $child;
        }
        $cn = (int) strlen($child);
        if ($cn === 0) {
            return $parent;
        }

        $c = $child;
        if (($cn > 1) && ($c{0} === $slash)) {
            if ($c{1} === $slash) {
                // drop prefix when child is a UNC pathname
                $c = substr($c, 2);
            } else {
                //Drop prefix when child is drive-relative */
                $c = substr($c, 1);
            }
        }

        $p = $parent;
        if ($p{$pn - 1} === $slash) {
            $p = substr($p, 0, $pn - 1);
        }
        return $p . $this->slashify($c);
    }

    public function getDefaultParent() {
        return (string) ("" . $this->slash);
    }

    public function fromURLPath($strPath) {
        $p = (string) $strPath;
        if ((strlen($p) > 2) && ($p{2} === ':')) {

            // "/c:/foo" --> "c:/foo"
            $p = substr($p, 1);

            // "c:/foo/" --> "c:/foo", but "c:/" --> "c:/"
            if ((strlen($p) > 3) && StringHelper::endsWith('/', $p)) {
                $p = substr($p, 0, strlen($p) - 1);
            }
        } elseif ((strlen($p) > 1) && StringHelper::endsWith('/', $p)) {
            // "/foo/" --> "/foo"
            $p = substr($p, 0, strlen($p) - 1);
        }
        return (string) $p;
    }

    /* -- Path operations -- */

    public function isAbsolute(File $f) {
        $pl = (int) $f->getPrefixLength();
        $p = (string) $f->getPath()->toNative();
        return ((($pl === 2) && ($p{0} === $this->slash)) || ($pl === 3) || ($pl === 1 && $p{0} === $this->slash));
    }

    /** private */
    private function _driveIndex($d) {
        $d = (string) $d{0};
        if ((ord($d) >= ord('a')) && (ord($d) <= ord('z'))) {
            return ord($d) - ord('a');
        }
        if ((ord($d) >= ord('A')) && (ord($d) <= ord('Z'))) {
            return ord($d) - ord('A');
        }
        return -1;
    }

    /** private */
    private function _getDriveDirectory($drive) {
        $drive = (string) $drive{0};
        $i = (int) $this->_driveIndex($drive);
        if ($i < 0) {
            return null;
        }

        $s = (isset(self::$driveDirCache[$i]) ? self::$driveDirCache[$i] : null);

        if ($s !== null) {
            return $s;
        }

        $s = $this->_getDriveDirectory($i + 1);
        self::$driveDirCache[$i] = $s;
        return $s;
    }

    private function _getUserPath() {
        //For both compatibility and security, we must look this up every time
        return (string) $this->normalize(\blaze\lang\System::getProperty("user.dir"));
    }

    private function _getDrive($path) {
        $path = (string) $path;
        $pl = $this->prefixLength($path);
        return ($pl === 3) ? substr($path, 0, 2) : null;
    }

    public function resolveFile(File $f) {
        $path = $f->getPath()->toNative();
        $pl = (int) $f->getPrefixLength();

        if (($pl === 2) && ($path{0} === $this->slash)) {
            return $path;            // UNC
        }

        if ($pl === 3) {
            return $path;            // Absolute local
        }

        if ($pl === 0) {
            return (string) ($this->_getUserPath() . $this->slashify($path)); //Completely relative
        }

        if ($pl === 1) {            // Drive-relative
            $up = (string) $this->_getUserPath();
            $ud = (string) $this->_getDrive($up);
            if ($ud !== null) {
                return (string) $ud . $path;
            }
            return (string) $up . $path;            //User dir is a UNC path
        }

        if ($pl === 2) {                // Directory-relative
            $up = (string) $this->_getUserPath();
            $ud = (string) $this->_getDrive($up);
            if (($ud !== null) && StringHelper::startsWith($ud, $path)) {
                return (string) ($up . $this->slashify(substr($path, 2)));
            }
            $drive = (string) $path{0};
            $dir = (string) $this->_getDriveDirectory($drive);

            $np = (string) "";
            if ($dir !== null) {
                /* When resolving a directory-relative path that refers to a
                  drive other than the current drive, insist that the caller
                  have read permission on the result */
                $p = (string) $drive . (':' . $dir . $this->slashify(substr($path, 2)));

                if (!$this->checkAccess($p, false)) {
                    // FIXME
                    // throw security error
                    die("Can't resolve path $p");
                }
                return $p;
            }
            return (string) $drive . ':' . $this->slashify(substr($path, 2)); //fake it
        }

        throw new Exception("Unresolvable path: " . $path);
    }

    /* -- most of the following is mapped to the functions mapped th php natives in FileSystem */

    /* -- Attribute accessors -- */

    public function setReadOnly($f) {
        // dunno how to do this on win
        throw new Exception("WIN32FileSystem doesn't support read-only yet.");
    }

    /* -- Filesystem interface -- */

    protected function _access($path) {
        if (!$this->checkAccess($path, false)) {
            throw new Exception("Can't resolve path $p");
        }
        return true;
    }

    private function nativeListRoots() {
        // FIXME
    }

    public function listRoots() {
        $ds = $this->nativeListRoots();
        $n = 0;
        for ($i = 0; $i < 26; $i++) {
            if ((($ds >> $i) & 1) !== 0) {
                if (!$this->access((string) ( chr(ord('A') + $i) . ':' . $this->slash))) {
                    $ds &= ~ (1 << $i);
                } else {
                    $n++;
                }
            }
        }
        $fs = array();
        $j = (int) 0;
        $slash = (string) $this->slash;
        for ($i = 0; $i < 26; $i++) {
            if ((($ds >> $i) & 1) !== 0) {
                $fs[$j++] = new File(chr(ord('A') + $i) . ':' . $this->slash);
            }
        }
        return $fs;
    }

    /* -- Basic infrastructure -- */

    /** compares file paths lexicographically */
    public function compare(File $f1, File $f2) {
        $f1Path = $f1->getPath()->toNative();
        $f2Path = $f2->getPath()->toNative();
        return strcasecmp((string) $f1Path, (string) $f2Path);
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

}

