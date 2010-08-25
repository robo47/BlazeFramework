<?php
namespace blaze\collections\map;
use blaze\lang\Object;

/**
 * Description of Property
 *
 * @author  Christian Beikov, Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class Properties implements \blaze\collections\Map {
    /**
     *
     * @var blaze\collections\map\HashMap
     */
    private $map;


    public function __construct(){
        $this->map = new HashMap();
    }

    public function setProperty($key, $value){
        $key =\blaze\lang\String::asNative($key);
        $value = \blaze\lang\String::asWrapper($value);
        if($this->map->containsKey($key)){
            return false;
        }
        else{
            $this->map->put($key, $value);
        }
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getProperty($key, $default = null){

        $key = \blaze\lang\String::asNative($key);

        if($this->map->containsKey($key))
                return $default;
        return $this->map->get($key);
    }
	
	/**
     * Load properties from a file.
     *
     * @param File $file
     * @return void
     * @throws IOException - if unable to read file.
     */
    public function load(\blaze\io\File $file) {
        if ($file->canRead()) {
            $this->parse($file->getPath(), false);                    
        } else {
            throw new IOException('Can not read file '.$file->getPath());
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
            throw new \blaze\io\IOException('Unable to parse contents of '.$filePath);
        }
        
        $this->map->clear();
        $sec_name = '';
        
        foreach($lines as $line) {
            
            $line = trim($line);
    
            if($line == '')
                continue;
                    
            if ($line{0} == '#' or $line{0} == ';') {
                // it's a comment, so continue to next line
                continue;
            } else {
                $pos = strpos($line, '=');
                $property = trim(substr($line, 0, $pos));
                $value = trim(substr($line, $pos + 1));                
                $this->map->put($property,$value);
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
        if ($val === 'true') {
            $val = true;
        } elseif ($val === 'false') {
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
            $val = 'true';
        } elseif ($val === false) {
            $val = 'false';
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
        $buf = '';

        foreach($this->map as $entry) {
            $buf .= $entry->getKey() . '=' . $this->outVal($entry->getValue()) . PHP_EOL;
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
    public function store(\blaze\io\File $file, $header = null) {
        // stores the properties in this object in the file denoted
        // if file is not given and the properties were loaded from a
        // file prior, this method stores them in the file used by load()        
        try {
            $fw = new \blaze\io\output\FileWriter($file);
            if ($header !== null) {
                $fw->write( '# ' . $header . PHP_EOL );
            }
            $fw->write($this->toString());
            $fw->close();
        } catch (\blaze\io\IOException $e) {
            throw new \blaze\io\IOException('Error writing property file: ' . $e->getMessage());
        }                
    }
    
    /**
     * Returns copy of internal properties hash.
     * Mostly for performance reasons, property hashes are often
     * preferable to passing around objects.
     *
     * @return array
     */
    public function getProperties() {
        return $this->map->keySet()->toArray();
    }
    
    /**
     * Set the value for a property.
     * This function exists to provide hashtable-lie
     * interface for properties.
     *
     * @param string $key
     * @param mixed $value
     */
    public function put($key, $value) {
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
    public function append($key, $value, $delimiter = ',') {
        $key = \blaze\lang\String::asNative($key);
        $newValue = $value;
        if($this->map->containsKey($key)){
            $newValue=$this->map->get($key).$delimiter.$value;
        }
       $this->map->put($key, $newvalue);
    }

    /**
     * Same as keys() function, returns an array of property names.
     * @return array
     */
    public function propertyNames() {
        return $this->map->keySet()->toArray();
    }
    
    /**
     * Whether loaded properties array contains specified property name.
     * @return boolean
     */
    public function containsKey($key) {
        $key = \blaze\lang\String::asNative($key);
        return $this->map->containsKey($key);
    }

    /**
     * Returns properties keys.
     * Use this for foreach() {} iterations, as this is
     * faster than looping through property values.
     * @return array
     */
    public function keys() {
        return $this->propertyNames();
    }
    
    /**
     * Whether properties list is empty.
     * @return boolean
     */
    public function isEmpty() {
        return $this->map->isEmpty();
    }

    public function clear(){
        $this->map->clear();
    }

   

    public function containsValue($value){
        $value = \blaze\lang\String::asWrapper($value);
       return $this->map->containsValue($value);
    }

    public function entrySet(){
        return $this->map->entrySet();
    }
    public function keySet(){
        return $this->map->keySet();
    }
    public function valueSet(){
        return $this->map->valueSet();
    }

    public function get($key){
        $key = \blaze\lang\String::asNative($key);
        return $this->map->get($key);
  }
   

    public function putAll(\blaze\collections\Map $m){
       return $this->map->putAll($m);
    }


    public function remove($key){
   $key = \blaze\lang\String::asNative($key);
    return $this->map->remove($key);
    }

    public function values(){
        return $this->map->values();
    }




    public function count(){
        return $this->map->count();
    }
    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator(){
        return $this->map->getIterator();
    }
/**
 *
 * @param \blaze\collections\Map $c
 * @return <type>
 * @todo Implement
 */
    public function containsAll(\blaze\collections\Map $c) {
        return $this->map->containsAll($c);

    }

    public function removeAll(Map $obj) {
        return $this->map->removeAll($obj);
    }

    public function retainAll(Map $obj) {
        return $this->map->retainAll($obj);
    }


}

?>
