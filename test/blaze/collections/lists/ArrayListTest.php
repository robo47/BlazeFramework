<<<<<<< HEAD
<?php

namespace blaze\collections\lists;

/**
 * Test class for ArrayList.
 * Generated by PHPUnit on 2010-08-18 at 14:18:59.
 */
class ArrayListTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ArrayList
     */
    protected $object;

    protected function setUp() {
        $this->object = new ArrayList();
        $this->object = new ArrayList();
        for($i = 0;$i<10;$i++){
           $this->object->add($i);
        }
    }

    protected function tearDown() {

    }

    public function testAdd() {
        // Remove the following lines when you implement this test.
                   $this->object->add(10);
           $this->assertTrue($this->object->get(10)->toNative()==10);
    }

    public function testAddAll() {
        // Remove the following lines when you implement this test.
        $this->object->addAt(3, 11);
        $this->assertTrue($this->object->get(3)->toNative()==11);
        $this->assertTrue($this->object->get(4)->toNative()==3);
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
        $it = $this->object->getIterator();
        $this->assertTrue($it instanceof \Iterator);
        $i = 0;
        $assert = false;
        foreach($this->object as $val){
            $assert = true;
            $this->assertTrue($val->toNative() == $i);
            $i++;
        }
        $this->assertTrue($assert);
        $it->next();
        $this->assertTrue($it->current()->toNative() === 1);
        $it->next();
        $it->next();
        $it->next();
        $it->remove();


    }

    public function testCount() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->count() == 10);
        $this->object->add(99);
        $this->assertTrue($this->object->count() == 11);
        $this->object->clear();
        $this->assertTrue($this->object->count() == 0);

    }

    public function testContains() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->contains(5));
        $this->assertFalse($this->object->contains(9999));
    }

    public function testContainsAll() {
        // Remove the following lines when you implement this test.
       $list = $this->object->subList(2, 4);
       $this->assertTrue($this->object->containsAll($list));
       $list->add(89);
       $this->assertFalse($this->object->containsAll($list));

    }

    public function testRemove() {
        // Remove the following lines when you implement this test.

        $this->object->remove(4);
        $this->assertTrue($this->object->count() == 9);
        $this->assertTrue($this->object->indexOf(4)==-1);
    }

    public function testRemoveAll() {
        // Remove the following lines when you implement this test.
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        
        $this->assertTrue($this->object->removeAll($list));
        $this->assertTrue($this->object->count()==8);
        
        $list = new ArrayList();
        $list->add(1);
        $list->add(7852);
        
        $this->assertFalse($this->object->removeAll($list));
        $this->assertTrue($this->object->count()==8);
 
    }

    public function testRetainAll() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->retainAll($list = $this->object->subList(2, 8)));
        $this->assertTrue($this->object->count()==6);
        $this->assertTrue($this->object->get(0)==2);

        $list = $this->object->subList(2, 4);
        $list->add(5468);

        $this->assertFalse($this->object->retainAll($list));

    }

    public function testToArray() {
        // Remove the following lines when you implement this test.
        $this->assertTrue(\is_array($this->object->toArray()));
    }

    public function testAddAllAt() {
        // Remove the following lines when you implement this test.
        $list = new ArrayList();
        $list->add(111);
        $list->add(222);
        $list->add(333);

        $this->object->addAllAt(4,$list);
    }

    public function testAddAt() {
        // Remove the following lines when you implement this test.
        $this->object->addAt(3, 11);
        $this->assertTrue($this->object->get(3)->toNative()==11);
        $this->assertTrue($this->object->get(4)->toNative()==3);
    }

    public function testGet() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->get(0)->toNative()==0);
        $this->assertTrue($this->object->get(5)->toNative()==5);
        $this->assertTrue($this->object->get(8)->toNative()==8);
    }

    public function testIndexOf() {
        // Remove the following lines when you implement this test.
       $this->assertTrue($this->object->indexOf(3)==3);
       $this->assertTrue($this->object->indexOf(45)==-1);
    }

    public function testLastIndexOf() {
        // Remove the following lines when you implement this test.
        $this->object->add(5);
        $this->object->add(5);
        $this->assertTrue($this->object->indexOf(5)==5);
        $this->assertTrue($this->object->lastIndexOf(5)==11);
    }

    public function testListIterator() {
        // Remove the following lines when you implement this test.
        $it = $this->object->listIterator();

        $this->assertTrue($it instanceof \Iterator);
        $i = 0;
        $assert = false;
        foreach($this->object as $val){
            $assert = true;
            $this->assertTrue($val->toNative() == $i);
            $i++;
        }
        $this->assertTrue($assert);
        $it->next();
        $this->assertTrue($it->current()->toNative() === 1);
        $it->next();
        $it->next();
        $it->next();
        $it->remove();

    }

    public function testRemoveAt() {
        // Remove the following lines when you implement this test.
        $this->object->removeAt(5);
        $this->assertTrue($this->object->indexOf(5)!=5);
    }

   
    public function testSet() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->set(2, 69)->toNative()==2);
        $this->assertTrue($this->object->get(2)->toNative()==69);
        $this->assertTrue($this->object->indexOf(69)==2);
    }

    public function testSubList() {
        // Remove the following lines when you implement this test.
        $list = $this->object->subList(2, 5);
        $this->assertTrue($list->get(0)->toNative()==2);
        $this->assertTrue($list->get(1)->toNative()==3);
        $this->assertTrue($list->get(2)->toNative()==4);

        $list = $this->object->subList(2, 5,false);
        $this->assertTrue($list->get(0)->toNative()==3);
        $this->assertTrue($list->get(1)->toNative()==4);

        $list = $this->object->subList(2, 5,false,true);
        $this->assertTrue($list->get(0)->toNative()==3);
        $this->assertTrue($list->get(1)->toNative()==4);
        $this->assertTrue($list->get(2)->toNative()==5);


    }



}

?>
=======
<?php

namespace blaze\collections\lists;

/**
 * Test class for ArrayList.
 * Generated by PHPUnit on 2010-08-18 at 14:18:59.
 */
class ArrayListTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ArrayList
     */
    protected $object;

    protected function setUp() {
        $this->object = new ArrayList();
        $this->object = new ArrayList();
        for($i = 0;$i<10;$i++){
           $this->object->add($i);
        }
    }

    protected function tearDown() {

    }

    public function testAdd() {
        // Remove the following lines when you implement this test.
                   $this->object->add(10);
           $this->assertTrue($this->object->get(10)->toNative()==10);
    }

    public function testAddAll() {
        // Remove the following lines when you implement this test.
        $this->object->addAt(3, 11);
        $this->assertTrue($this->object->get(3)->toNative()==11);
        $this->assertTrue($this->object->get(4)->toNative()==3);
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
        $it = $this->object->getIterator();
        $this->assertTrue($it instanceof \Iterator);
        $i = 0;
        $assert = false;
        foreach($this->object as $val){
            $assert = true;
            $this->assertTrue($val->toNative() == $i);
            $i++;
        }
        $this->assertTrue($assert);
        $it->next();
        $this->assertTrue($it->current()->toNative() === 1);
        $it->next();
        $it->next();
        $it->next();
        $it->remove();


    }

    public function testCount() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->count() == 10);
        $this->object->add(99);
        $this->assertTrue($this->object->count() == 11);
        $this->object->clear();
        $this->assertTrue($this->object->count() == 0);

    }

    public function testContains() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->contains(5));
        $this->assertFalse($this->object->contains(9999));
    }

    public function testContainsAll() {
        // Remove the following lines when you implement this test.
       $list = $this->object->subList(2, 4);
       $this->assertTrue($this->object->containsAll($list));
       $list->add(89);
       $this->assertFalse($this->object->containsAll($list));

    }

    public function testRemove() {
        // Remove the following lines when you implement this test.

        $this->object->remove(4);
        $this->assertTrue($this->object->count() == 9);
        $this->assertTrue($this->object->indexOf(4)==-1);
    }

    public function testRemoveAll() {
        // Remove the following lines when you implement this test.
        $list = new ArrayList();
        $list->add(1);
        $list->add(2);
        
        $this->assertTrue($this->object->removeAll($list));
        $this->assertTrue($this->object->count()==8);
        
        $list = new ArrayList();
        $list->add(1);
        $list->add(7852);
        
        $this->assertFalse($this->object->removeAll($list));
        $this->assertTrue($this->object->count()==8);
 
    }

    public function testRetainAll() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->retainAll($list = $this->object->subList(2, 8)));
        $this->assertTrue($this->object->count()==6);
        $this->assertTrue($this->object->get(0)==2);

        $list = $this->object->subList(2, 4);
        $list->add(5468);

        $this->assertFalse($this->object->retainAll($list));

    }

    public function testToArray() {
        // Remove the following lines when you implement this test.
        $this->assertTrue(\is_array($this->object->toArray()));
    }

    public function testAddAllAt() {
        // Remove the following lines when you implement this test.
        $list = new ArrayList();
        $list->add(111);
        $list->add(222);
        $list->add(333);

        $this->object->addAllAt(4,$list);
    }

    public function testAddAt() {
        // Remove the following lines when you implement this test.
        $this->object->addAt(3, 11);
        $this->assertTrue($this->object->get(3)->toNative()==11);
        $this->assertTrue($this->object->get(4)->toNative()==3);
    }

    public function testGet() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->get(0)->toNative()==0);
        $this->assertTrue($this->object->get(5)->toNative()==5);
        $this->assertTrue($this->object->get(8)->toNative()==8);
    }

    public function testIndexOf() {
        // Remove the following lines when you implement this test.
       $this->assertTrue($this->object->indexOf(3)==3);
       $this->assertTrue($this->object->indexOf(45)==-1);
    }

    public function testLastIndexOf() {
        // Remove the following lines when you implement this test.
        $this->object->add(5);
        $this->object->add(5);
        $this->assertTrue($this->object->indexOf(5)==5);
        $this->assertTrue($this->object->lastIndexOf(5)==11);
    }

    public function testListIterator() {
        // Remove the following lines when you implement this test.
        $it = $this->object->listIterator();

        $this->assertTrue($it instanceof \Iterator);
        $i = 0;
        $assert = false;
        foreach($this->object as $val){
            $assert = true;
            $this->assertTrue($val->toNative() == $i);
            $i++;
        }
        $this->assertTrue($assert);
        $it->next();
        $this->assertTrue($it->current()->toNative() === 1);
        $it->next();
        $it->next();
        $it->next();
        $it->remove();

    }

    public function testRemoveAt() {
        // Remove the following lines when you implement this test.
        $this->object->removeAt(5);
        $this->assertTrue($this->object->indexOf(5)!=5);
    }

   
    public function testSet() {
        // Remove the following lines when you implement this test.
        $this->assertTrue($this->object->set(2, 69)->toNative()==2);
        $this->assertTrue($this->object->get(2)->toNative()==69);
        $this->assertTrue($this->object->indexOf(69)==2);
    }

    public function testSubList() {
        // Remove the following lines when you implement this test.
        $list = $this->object->subList(2, 5);
        $this->assertTrue($list->get(0)->toNative()==2);
        $this->assertTrue($list->get(1)->toNative()==3);
        $this->assertTrue($list->get(2)->toNative()==4);

        $list = $this->object->subList(2, 5,false);
        $this->assertTrue($list->get(0)->toNative()==3);
        $this->assertTrue($list->get(1)->toNative()==4);

        $list = $this->object->subList(2, 5,false,true);
        $this->assertTrue($list->get(0)->toNative()==3);
        $this->assertTrue($list->get(1)->toNative()==4);
        $this->assertTrue($list->get(2)->toNative()==5);


    }



}

?>
>>>>>>> 30908ff908011e6657fa44fbda73dc71056c40b0
