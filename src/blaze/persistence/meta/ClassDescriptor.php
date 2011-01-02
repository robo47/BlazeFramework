<?php
namespace blaze\persistence\meta;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class ClassDescriptor extends Object{

    /**
     *
     * @var \blaze\collections\Map
     */
    private static $classDescriptors;
    /**
     * The name of the class.
     * @var blaze\lang\String
     */
    private $name;
    /**
     * The package where the class is in.
     * @var blaze\lang\String
     */
    private $package;
    /**
     * The identifiers of a class.
     * @var blaze\collections\ListI[blaze\persistence\meta\IdDescriptor]
     */
    private $identifiers;
    /**
     * The fields of a class.
     * @var blaze\collections\ListI[blaze\persistence\meta\SingleFieldDescriptor]
     */
    private $singleFields;
    /**
     * Collections which exist because of realtions between entities.
     * @var blaze\collections\ListI[blaze\persistence\meta\CollectionFieldDescriptor]
     */
    private $collectionFields;
    /**
     * The table which is related to that class
     * @var blaze\persistence\meta\TableDescriptor
     */
    private $tableDescriptor;
    /**
     * The super class if there is any
     * @var blaze\persistence\meta\ClassDescriptor
     */
    private $superClassDescriptor;

    public static function getClassDescriptor($name){
        $name = \blaze\lang\String::asNative($name);
        if(self::$classDescriptors === null)
            self::$classDescriptors = array();//new \blaze\collections\map\HashMap();
        $cd = isset(self::$classDescriptors[$name]) ? self::$classDescriptors[$name] : null;//self::$classDescriptors->get($name);

        if($cd === null){
            $cd = new ClassDescriptor();
            $cd->setName($name);
            self::$classDescriptors[$name] = $cd;//self::$classDescriptors->put($name, $cd);
        }

        return $cd;
    }

    public function __construct() {
        $this->singleFields = new \blaze\collections\lists\ArrayList();
        $this->identifiers = new \blaze\collections\lists\ArrayList();
        $this->collectionFields = new \blaze\collections\lists\ArrayList();
    }

    /**
     * @return blaze\lang\String
     */
    public function getFullName(){
        if($this->package != null)
                return $this->package.'\\'.$this->name;
        return $this->name;
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @param string|blaze\lang\String $name
     */
    public function setName($name) {
        $this->name = \blaze\lang\String::asWrapper($name);
    }

    /**
     *
     * @return blaze\lang\String
     */
    public function getPackage() {
        return $this->package;
    }

    /**
     *
     * @param string|blaze\lang\String $package
     */
    public function setPackage($package) {
        $this->package = \blaze\lang\String::asWrapper($package);
    }

    /**
     *
     * @return blaze\collections\ListI[blaze\persistence\meta\IdDescriptor]
     */
    public function getIdentifiers() {
        return $this->identifiers;
    }

    /**
     *
     * @param \blaze\persistence\meta\IdDescriptor $identifier
     */
    public function addIdentifier(\blaze\persistence\meta\IdDescriptor $identifier) {
        $this->identifiers->add($identifier);
    }

    /**
     *
     * @return blaze\collections\ListI[blaze\persistence\meta\PropertyDescriptor]
     */
    public function getSingleFields() {
        return $this->singleFields;
    }

    /**
     *
     * @param \blaze\persistence\meta\SingleFieldDescriptor $singleField
     */
    public function addSingleField(\blaze\persistence\meta\SingleFieldDescriptor $singleField) {
        $this->singleFields->add($singleField);
    }

    /**
     *
     * @return blaze\collections\ListI[blaze\persistence\meta\ManyToManyDescriptor]
     */
    public function getCollectionFields() {
        return $this->collectionFields;
    }

    /**
     *
     * @param \blaze\persistence\meta\CollectionFieldDescriptor $collectionField
     */
    public function addCollectionField(\blaze\persistence\meta\CollectionFieldDescriptor $collectionField) {
        $this->collectionFields->add($collectionField);
    }

    /**
     *
     * @return \blaze\persistence\meta\TableDescriptor
     */
    public function getTableDescriptor() {
        return $this->tableDescriptor;
    }

    /**
     *
     * @param \blaze\persistence\meta\TableDescriptor $tableDescriptor
     */
    public function setTableDescriptor(\blaze\persistence\meta\TableDescriptor $tableDescriptor) {
        $this->tableDescriptor = $tableDescriptor;
    }

    /**
     *
     * @return \blaze\persistence\meta\ClassDescriptor
     */
    public function getSuperClassDescriptor() {
        return $this->superClassDescriptor;
    }

    /**
     *
     * @param \blaze\persistence\meta\ClassDescriptor $superClassDescriptor
     */
    public function setSuperClassDescriptor(\blaze\persistence\meta\ClassDescriptor $superClassDescriptor) {
        $this->superClassDescriptor = $superClassDescriptor;
    }

    public function generate(\blaze\lang\StringBuffer $buffer){
        if ($this->package != null) {
            $packageName = $this->package;
            $className = $this->name;
        } else {
            $idx = $this->name->lastIndexOf('\\');
            $packageName = $this->name->substring(0, $idx)->toNative();
            $className = $this->name->substring($idx + 1)->toNative();
        }

        $buffer->append('<?php '.PHP_EOL.PHP_EOL);
        $buffer->append('namespace ');
        $buffer->append($packageName);
        $buffer->append(';' . PHP_EOL.PHP_EOL);
        $buffer->append('class ');
        $buffer->append($className);
        $buffer->append(' extends \\blaze\\lang\\Object {' . PHP_EOL.PHP_EOL);

        foreach($this->identifiers as $member) {
            $member->generate($buffer);
        }

        foreach($this->singleFields as $member) {
            $member->generate($buffer);
        }

        foreach($this->collectionFields as $member) {
            $member->generate($buffer);
        }

        $buffer->append('}');
    }

}

?>
