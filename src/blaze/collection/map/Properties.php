<?php
namespace blaze\collection\map;
use blaze\lang\Object;

/**
 * Description of Property
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Properties extends HashMap {
    /**
     *
     * @var array
     */
    private $props = array();

    public function setProperty($key, $value){
        $this->props[\blaze\lang\String::asNative($key)] = \blaze\lang\String::asWrapper($value);
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getProperty($key, $default = null){
        $key = \blaze\lang\String::asNative($key);
        if(!array_key_exists($key, $this->props))
                return $default;
        return $this->props[$key];
    }
	
	/**
     * Load properties from a file.
     *
     * @param File $file
     * @return void
     * @throws IOException - if unable to read file.
     */
    function load(File $file) {
        if ($file->canRead()) {
            $this->parse($file->getPath(), false);                    
        } else {
            throw new IOException("Can not read file ".$file->getPath());
        }
        
    }
    
    /**
     * Replaces parse_ini_file() or better_parse_ini_file().
     * Saves a step since we don't have to parse and then check return value
     * before throwing an error or setting class properties.
     * 
     * @param string $filePath
     * @param boolean $processSections Whether to honor [SectionName] sections in INI file.
     * @return array Properties loaded from file (no prop replacements done yet).
     */
    protected function parse($filePath) {

        // load() already made sure that file is readable                
        // but we'll double check that when reading the file into 
        // an array
        
        if (($lines = @file($filePath)) === false) {
            throw new IOException("Unable to parse contents of $filePath");
        }
        
        $this->properties = array();
        $sec_name = "";
        
        foreach($lines as $line) {
            
            $line = trim($line);
    
            if($line == "")
                continue;
                    
            if ($line{0} == '#' or $line{0} == ';') {
                // it's a comment, so continue to next line
                continue;
            } else {
                $pos = strpos($line, '=');
                $property = trim(substr($line, 0, $pos));
                $value = trim(substr($line, $pos + 1));                
                $this->properties[$property] = $this->inVal($value);
            }
            
        } // for each line        
    }
    
    /**
     * Process values when being read in from properties file.
     * does things like convert "true" => true
     * @param string $val Trimmed value.
     * @return mixed The new property value (may be boolean, etc.)
     */
    protected function inVal($val) {
        if ($val === "true") { 
            $val = true;
        } elseif ($val === "false") { 
            $val = false; 
        }
        return $val;
    }
    
    /**
     * Process values when being written out to properties file.
     * does things like convert true => "true"
     * @param mixed $val The property value (may be boolean, etc.)
     * @return string
     */
    protected function outVal($val) {
        if ($val === true) {
            $val = "true";
        } elseif ($val === false) {
            $val = "false";
        }
        return $val;
    }
    
    /**
     * Create string representation that can be written to file and would be loadable using load() method.
     * 
     * Essentially this function creates a string representation of properties that is ready to
     * write back out to a properties file.  This is used by store() method.
     *
     * @return string
     */
    public function toString() {
        $buf = "";        
        foreach($this->properties as $key => $item) {
            $buf .= $key . "=" . $this->outVal($item) . PHP_EOL;
        }
        return $buf;    
    }
    
    /**
     * Stores current properties to specified file.
     * 
     * @param File $file File to create/overwrite with properties.
     * @param string $header Header text that will be placed (within comments) at the top of properties file.
     * @return void
     * @throws IOException - on error writing properties file.
     */
    function store(File $file, $header = null) {
        // stores the properties in this object in the file denoted
        // if file is not given and the properties were loaded from a
        // file prior, this method stores them in the file used by load()        
        try {
            $fw = new FileWriter($file);
            if ($header !== null) {
                $fw->write( "# " . $header . PHP_EOL );
            }
            $fw->write($this->toString());
            $fw->close();
        } catch (IOException $e) {
            throw new IOException("Error writing property file: " . $e->getMessage());
        }                
    }
    
    /**
     * Returns copy of internal properties hash.
     * Mostly for performance reasons, property hashes are often
     * preferable to passing around objects.
     *
     * @return array
     */
    function getProperties() {
        return $this->properties;
    }


    /**
     * Get value for specified property.
     * This function exists to provide a hashtable-like interface for
     * properties.
     *
     * @param string $prop The property name (key).
     * @return mixed
     * @see getProperty()
     */    
    function get($prop) {
         if (!isset($this->properties[$prop])) {
            return null;
        }
        return $this->properties[$prop];
    }
    
    /**
     * Set the value for a property.
     * This function exists to provide hashtable-lie
     * interface for properties.
     *
     * @param string $key
     * @param mixed $value
     */
    function put($key, $value) {
        return $this->setProperty($key, $value);
    }
    
    /**
     * Appends a value to a property if it already exists with a delimiter
     *
     * If the property does not, it just adds it.
     * 
     * @param string $key
     * @param mixed $value
     * @param string $delimiter
     */
    function append($key, $value, $delimiter = ',') {
        $newValue = $value;
        if (isset($this->properties[$key]) && !empty($this->properties[$key]) ) {
            $newValue = $this->properties[$key] . $delimiter . $value;
        }
        $this->properties[$key] = $newValue;
    }

    /**
     * Same as keys() function, returns an array of property names.
     * @return array
     */
    function propertyNames() {
        return $this->keys();
    }
    
    /**
     * Whether loaded properties array contains specified property name.
     * @return boolean
     */
    function containsKey($key) {
        return isset($this->properties[$key]);
    }

    /**
     * Returns properties keys.
     * Use this for foreach() {} iterations, as this is
     * faster than looping through property values.
     * @return array
     */
    function keys() {
        return array_keys($this->properties);
    }
    
    /**
     * Whether properties list is empty.
     * @return boolean
     */
    function isEmpty() {
        return empty($this->properties);
    }
    
}

?>
