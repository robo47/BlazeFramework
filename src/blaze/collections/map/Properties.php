<?php

namespace blaze\collections\map;

use blaze\lang\Object;

/**
 * An implementation of a map which manages only entries with the key type
 * string and the value type string.
 *
 * @author  Christian Beikov, Oliver Kotzina
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @since   1.0
 * @todo    Clean up the implementation, no need to extend from HashMap because of associative arrays in PHP. Documentation!
 */
class Properties extends HashMap {

    /**
     *
     * @var array
     */
    private $properties = array();

    public function __construct() {

    }

    public function setProperty($key, $value) {
        if (array_key_exists($key, $this->properties)) {
            return false;
        } else {
            $this->properties[\blaze\lang\String::asNative($key)] = \blaze\lang\String::asWrapper($value);
        }
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getProperty($key, $default = null) {
        $key = \blaze\lang\String::asNative($key);
        if (!array_key_exists($key, $this->properties))
            return $default;
        return $this->properties[$key];
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
            throw new IOException('Can not read file ' . $file->getPath());
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
            throw new \blaze\io\IOException('Unable to parse contents of ' . $filePath);
        }

        $this->properties = array();
        $sec_name = '';

        foreach ($lines as $line) {

            $line = trim($line);

            if ($line == '')
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
        foreach ($this->properties as $key => $item) {
            $buf .= $key . '=' . $this->outVal($item) . PHP_EOL;
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
                $fw->write('# ' . $header . PHP_EOL);
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
        return $this->properties;
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
        $newValue = $value;
        if (isset($this->properties[$key]) && !empty($this->properties[$key])) {
            $newValue = $this->properties[$key] . $delimiter . $value;
        }
        $this->properties[$key] = $newValue;
    }

    /**
     * Same as keys() function, returns an array of property names.
     * @return array
     */
    public function propertyNames() {
        return $this->keys();
    }

    /**
     * Whether loaded properties array contains specified property name.
     * @return boolean
     */
    public function containsKey($key) {
        return isset($this->properties[$key]);
    }

    /**
     * Returns properties keys.
     * Use this for foreach() {} iterations, as this is
     * faster than looping through property values.
     * @return array
     */
    public function keys() {
        return array_keys($this->properties);
    }

    /**
     * Whether properties list is empty.
     * @return boolean
     */
    public function isEmpty() {
        return empty($this->properties);
    }

    public function clear() {
        $this->size = 0;
        $this->properties = array();
    }

    public function containsValue($value) {
        foreach ($this->properties as &$val) {
            if ($val == $value) {
                return true;
            }
        }
        return false;
    }

    public function entrySet() {

    }

    public function keySet() {

    }

    public function valueSet() {

    }

    public function get($key) {
        if (array_key_exists($key, $this->properties)) {
            return $this->data[$key]->getValue();
        }
        return null;
    }

    public function putAll(\blaze\collections\Map $m) {
        foreach ($m as $value) {
            $this->put($value->getKey(), $value->getValue());
        }
    }

    public function remove($key) {


        if ($this->containsKey($key)) {
            unset($this->data[$key]);
            return true;
        } else {
            return false;
        }
    }

    public function values() {

    }

    public function count() {
        return $this->size;
    }

    /**
     * @return blaze\collections\MapIterator
     */
    public function getIterator() {
        return new PropertiesIterator($this->properties);
    }

    /**
     *
     * @param \blaze\collections\Map $c
     * @return <type>
     * @todo Implement
     */
    public function containsAll(\blaze\collections\Map $c) {
        foreach ($c as $val) {
            if (!$this->containsKey($val->getKey())) {
                return false;
            }
        }
        return true;
    }

}

class PropertiesIterator implements \blaze\collections\MapIterator {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function current() {
        return current($this->data);
    }

    public function getKey() {
        return $this->key();
    }

    public function getValue() {
        return current($this->data);
    }

    public function hasNext() {
        if (next($this->data)) {
            prev($this->data);
            return true;
        } else {
            return false;
        }
    }

    public function key() {
        return key($this->data);
    }

    public function next() {
        return next($this->data);
    }

    public function remove() {
        unset($this->data[$this->key()]);
    }

    public function rewind() {
        reset($this->data);
    }

    public function setValue($value) {
        $old = current($this->data);
        $this->data[key($this->data)] = $value;
        return $old;
    }

    public function valid() {
        return (current($this->data) !== false);
    }

}

?>
