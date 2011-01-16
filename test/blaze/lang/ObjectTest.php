<<<<<<< HEAD
<?php
namespace blaze\lang;

class ObjectTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Object
     */
    protected $object;

    protected function setUp() {
        $this->object = new Object;
    }

    public function testCloneObject() {
        try{
            $this->object->cloneObject();
        }catch(\blaze\lang\CloneNotSupportedException $e){
            return;
        }catch(\Exception $e){
            $this->fail('Unexpected exception!');
        }

        $this->fail('Cloning should not be supported.');
    }

    public function testEquals() {
        $this->assertTrue($this->object->equals($this->object));
    }

    public function testClassWrapper() {
        $this->assertTrue($this->object->getClass()->equals(Object::classWrapper()));
    }

    public function testGetClass() {
        $class = $this->object->getClass();
        $this->assertNotNull($class);
        $this->assertEquals('blaze\lang\Object', $class->getName()->toNative());
        $this->assertEquals('blaze\lang\Object', ClassWrapper::forName('blaze\lang\Object')->getName()->toNative());
    }

    public function testHashCode() {
        $this->assertNotNull($this->object->hashCode());
    }

    public function testToString() {
        $this->assertRegExp('/blaze\\\\lang\\\\Object@[A-F0-9]*/', $this->object->toString()->toNative());
    }
}
?>
=======
<?php
namespace blaze\lang;

class ObjectTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Object
     */
    protected $object;

    protected function setUp() {
        $this->object = new Object;
    }

    public function testCloneObject() {
        try{
            $this->object->cloneObject();
        }catch(\blaze\lang\CloneNotSupportedException $e){
            return;
        }catch(\Exception $e){
            $this->fail('Unexpected exception!');
        }

        $this->fail('Cloning should not be supported.');
    }

    public function testEquals() {
        $this->assertTrue($this->object->equals($this->object));
    }

    public function testClassWrapper() {
        $this->assertTrue($this->object->getClass()->equals(Object::classWrapper()));
    }

    public function testGetClass() {
        $class = $this->object->getClass();
        $this->assertNotNull($class);
        $this->assertEquals('blaze\lang\Object', $class->getName()->toNative());
        $this->assertEquals('blaze\lang\Object', ClassWrapper::forName('blaze\lang\Object')->getName()->toNative());
    }

    public function testHashCode() {
        $this->assertNotNull($this->object->hashCode());
    }

    public function testToString() {
        $this->assertRegExp('/blaze\\\\lang\\\\Object@[A-F0-9]*/', $this->object->toString()->toNative());
    }
}
?>
>>>>>>> 30908ff908011e6657fa44fbda73dc71056c40b0
