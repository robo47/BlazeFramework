<?php

namespace blaze\collections\set;

/**
 * Test class for HashSet.
 * Generated by PHPUnit on 2010-08-20 at 17:32:57.
 */
class HashSetTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var HashSet
     */
    protected $object;

    protected function setUp() {
        $this->object = new HashSet();
        for($i = 0; $i<10;$i++){
            $this->object->add($i);
        }
        
    }

    protected function tearDown() {

    }

    public function testAdd() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->add(456));
        $this->assertFalse($this->object->add(456));
        $this->assertTrue($this->object->contains(456));
    }

    public function testAddAll() {
        // Remove the following lines when you implement this test.
        $col = new HashSet();
        $col->add(1);
        $col->add(5);
        $col->add(6);
        $col->add(2);
        $this->assertFalse($this->object->addAll($col));
        $col->add(788);
        $this->assertTrue($this->object->addAll($col));
        
    }

    public function testClear() {
        // Remove the following lines when you implement this test.
        $this->object->clear();
        $this->assertTrue($this->object->count()==0);
    }

    public function testIsEmpty() {
        // Remove the following lines when you implement this test.
        $this->assertFalse($this->object->isEmpty());
        $this->object->clear();
        $this->assertTrue($this->object->isEmpty());
    }

    public function testGetIterator() {
        // Remove the following lines when you implement this test.
        $it =$this->object->getIterator();
        $this->assertTrue($it instanceof \blaze\collections\Iterator);
        $test = false;
        foreach($this->object as $val){
            $test = true;
        }
        $this->assertTrue($test);
    }

    public function testCount() {
        // Remove the following lines when you implement this test.
        //$this->assertTrue($this->count()==10);
        $this->object->add(546);
        $this->assertFalse($this->count()==10);

    }

    public function testContains() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->contains(5));
        $this->assertFalse($this->object->contains(88));
    }

    public function testContainsAll() {
        // Remove the following lines when you implement this test.
        $col = new HashSet();
        $col->add(1);
        $col->add(5);
        $col->add(6);
        $col->add(2);
        $this->assertTrue($this->object->containsAll($col));
        $col->add(788);
        $this->assertFalse($this->object->containsAll($col));
    }

    public function testRemove() {
        // Remove the following lines when you implement this test.
        $this->assertFalse($this->object->remove(89));
        $this->assertTrue($this->object->remove(5));
        $this->assertFalse($this->object->contains(5));

    }

    public function testRemoveAll() {
        // Remove the following lines when you implement this test.
        $col = new HashSet();
        $col->add(89);
        $col->add(78978);
        $col->add(789);
        $col->add(456);
        $this->assertFalse($this->object->removeAll($col));
        $col->add(4);
        $this->assertTrue($this->object->removeAll($col));
    }

    public function testRetainAll() {
        // Remove the following lines when you implement this test.
        $col = new \blaze\collections\lists\ArrayList();
        $col->add(5);
        $col->add(2);
        $col->add(1);
        $this->object->retainAll($col);

    }

    public function testToArray() {
        // Remove the following lines when you implement this test.
        $this->assertTrue(\is_array($this->object->toArray()));
    }

}
?>