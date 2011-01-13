<?php

namespace blaze\collections\map;

/**
 * Test class for HashMap.
 * Generated by PHPUnit on 2010-08-20 at 07:30:49.
 */
class HashMapTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var HashMap
     */
    protected $object;

    protected function setUp() {
        $this->object = new HashMap();
           for($a = 0;$a<10;$a++){
               $this->object->put($a,$a);
           }

    }

    protected function tearDown() {

    }

    public function testClear() {
        // Remove the following lines when you implement this test.
        $this->object->clear();
        $this->assertTrue($this->object->count()==0);
    }

    public function testContainsKey() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->containsKey(5));
        $this->assertFalse($this->object->containsKey(896));
    }

    public function testContainsValue() {
        // Remove the following lines when you implement this test.
     $this->assertTrue($this->object->containsValue(5));
     $this->assertFalse($this->object->containsValue(896));
    }

    public function testEntrySet() {
        // Remove the following lines when you implement this test.
        $set = $this->object->entrySet();

    }

    public function testKeySet() {
        // Remove the following lines when you implement this test.
       $set = $this->object->keySet();
       $this->assertTrue($set->contains(0));
    }

    public function testValueSet() {
        // Remove the following lines when you implement this test.
        $set = $this->object->valueSet();
        $this->assertTrue($set->contains(0));
    }

    public function testGet() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->get(5)==5);
        $this->assertTrue($this->object->get(79)==null);
    }

    public function testPut() {
        // Remove the following lines when you implement this test.
        $this->object->put(78,'hallo');
        $this->assertTrue($this->object->get(78)=='hallo');
        $this->assertTrue($this->object->containsValue('hallo'));
        

    }

    public function testPutAll() {
        // Remove the following lines when you implement this test.
       $hashmap = new HashMap();
       $hashmap->put(87, 48);
       $hashmap->put(45,98);
       $hashmap->put(7889, 4);

       $this->object->putAll($hashmap);


       $this->assertTrue($this->object->get(87)==48);
       $this->assertTrue($this->object->containsValue(48));

       $this->assertTrue($this->object->get(45)==98);
       $this->assertTrue($this->object->containsValue(98));
                
       $this->assertTrue($this->object->get(7889)==4);
       $this->assertTrue($this->object->containsValue(4));
    }

    public function testRemove() {
        // Remove the following lines when you implement this test.
        var_dump($this->object);
       $this->assertTrue($this->object->remove(5));
       var_dump($this->object);
       $this->assertFalse($this->object->remove(99));
       var_dump($this->object);
    }

    public function testValues() {
        // Remove the following lines when you implement this test.
        $col = $this->object->values();
   
        
    }

    public function testIsEmpty() {
        // Remove the following lines when you implement this test.
        $this->assertFalse($this->object->isEmpty());
        $this->object->clear();
        $this->assertTrue($this->object->isEmpty());
    }

    public function testCount() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->count()==10);
    }

    public function testGetIterator() {
        // Remove the following lines when you implement this test.
      $it = $this->object->getIterator();
      $this->assertTrue($it instanceof \blaze\collections\MapIterator);

       $test = false;
        foreach($this->object as $val){

            $test = true;
        }
        $this->assertTrue($test);
        $it->next();
        $it->next();
        $it->next();
        $it->next();
        $it->remove();
    }

    public function testContainsAll() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->containsAll($this->object));
        $map = new HashMap();
        $map->put(5,5);
        $map->put(78, 54);
        $this->assertFalse($this->object->containsAll($map));
    }

    public function testRemoveAll() {
        // Remove the following lines when you implement this test.
        $map = new HashMap();
        $map->put(5,5);
        $map->put(6,6);
        $this->assertTrue($this->object->removeAll($map));
        $this->assertFalse($this->object->containsKey(5));
        $map = new HashMap();
        $map->put(8,5);
        $map->put(78,6);
        $this->assertTrue($this->object->removeAll($map));

    }

    public function testRetainAll() {
        // Remove the following lines when you implement this test.
        $map = new HashMap();
        $map->put(1, 1);
        $map->put(2, 5);
        $map->put(3, 3);
        $this->object->retainAll($map);

    }

}
?>
