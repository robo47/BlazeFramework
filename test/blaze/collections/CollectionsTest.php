<?php

namespace blaze\collections;
        use blaze\lang\Comparator;

/**
 * Test class for Collections.
 * Generated by PHPUnit on 2010-08-24 at 15:25:41.
 */
class CollectionsTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Collections
     */
    protected $object;

    public function getList() {
        $ar = new lists\ArrayList();
        $ar->add(new \blaze\lang\Integer(5));
        $ar->add(new \blaze\lang\Integer(98));
        $ar->add(new \blaze\lang\Integer(1));
        $ar->add(new \blaze\lang\Integer(5));
        $ar->add(new \blaze\lang\Integer(68));
        $ar->add(new \blaze\lang\Integer(2));
        $ar->add(new \blaze\lang\Integer(5));
        $ar->add(new \blaze\lang\Integer(67));
        return $ar;
    }

    protected function tearDown() {

    }

    public function testAddAll() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
       
    }

    public function testBinarySearch() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBinaryRangeSearch() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testCopyOf() {
        // Remove the following lines when you implement this test.
        $list = new lists\ArrayList();
        Collections::copyOf($this->getList(), $list);
        $this->assertTrue($list->get(0) == $list->get(0));
        $this->assertTrue($list->get(2) == $list->get(2));
        $this->assertTrue($list->get(5) == $list->get(5));
        $this->assertTrue($list->get(6) == $list->get(6));
        $this->assertTrue($list->get(7) == $list->get(7));
    }

    public function testCopyOfRange() {
        // Remove the following lines when you implement this test.
        $dest = new lists\ArrayList();
		$list = $this->getList();
        Collections::copyOfRange($list,2, 6, $dest);
        $this->assertTrue($list->get(2) == $dest->get(0));
        $this->assertTrue($list->get(3) == $dest->get(1));
        $this->assertTrue($list->get(4) == $dest->get(2));
        $this->assertTrue($list->get(5) == $dest->get(3));

    }

    public function testFill() {
        // Remove the following lines when you implement this test.
		$list = $this->getList();
        Collections::fill($list, new \blaze\lang\Integer(99));
        $this->assertTrue($list->get(0)->equals(new \blaze\lang\Integer(99)));
        $this->assertTrue($list->get(2)->equals(new \blaze\lang\Integer(99)));
        $this->assertTrue($list->get(5)->equals(new \blaze\lang\Integer(99)));
        $this->assertTrue($list->get(6)->equals(new \blaze\lang\Integer(99)));
        $this->assertTrue($list->get(7)->equals(new \blaze\lang\Integer(99)));
    }

    public function testFillRange() {
        // Remove the following lines when you implement this test.
		$list = $this->getList();
       Collections::fillRange($list, 2, 6, new \blaze\lang\Integer(99));

        $this->assertTrue($list->get(2)->equals(new \blaze\lang\Integer(99)));
        $this->assertTrue($list->get(3)->equals(new \blaze\lang\Integer(99)));
        $this->assertTrue($list->get(4)->equals(new \blaze\lang\Integer(99)));
        $this->assertTrue($list->get(5)->equals(new \blaze\lang\Integer(99)));
        $this->assertFalse($list->get(6)->equals(new \blaze\lang\Integer(99)));

    }

    public function testIndexOfSubList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testLastIndexOfSubList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testMax() {
        // Remove the following lines when you implement this test.
        $this->assertTrue(Collections::max($this->getList())->equals(new \blaze\lang\Integer(98)));

    }

    public function testMin() {
        // Remove the following lines when you implement this test.
        $this->assertTrue(Collections::min($this->getList())->equals(new \blaze\lang\Integer(1)));
    }

    public function testReplaceAll() {
        // Remove the following lines when you implement this test.
		$list = $this->getList();
        Collections::replaceAll($list, new \blaze\lang\Integer(5), 'replaced');
        $this->assertTrue($list->get(0)->equals('replaced'));
        $this->assertTrue($list->get(3)->equals('replaced'));
        
       

    }

    public function testReverse() {
        // Remove the following lines when you implement this test.
		$list = $this->getList();
        Collections::reverse($list);
        $this->assertTrue($list->get(0)->equals(new \blaze\lang\Integer(67)));
        $this->assertTrue($list->get(7)->equals(new \blaze\lang\Integer(5)));
    }

    public function testReverseComperator() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testSort() {
        // Remove the following lines when you implement this test.
        
		$list = $this->getList();
        Collections::sort($list);
        $this->assertTrue(Collections::binarySearch($list, new \blaze\lang\Integer(98), null)==7);     
    }

    public function testSortRange() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testSwap() {
        // Remove the following lines when you implement this test.
		$list = $this->getList();
        Collections::swap($list, 0, 7);
        $this->assertTrue($list->get(0)->equals(new \blaze\lang\Integer(67)));
        $this->assertTrue($list->get(7)->equals(new \blaze\lang\Integer(5)));

    }

    public function testDeepEquals() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedCollection() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedSortedCollection() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedBag() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedSortedBag() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedSet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedSortedSet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedSortedMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedBidiMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testBoundedSortedBidiMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableCollection() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableSortedCollection() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableBag() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableSortedBag() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableSet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableSortedSet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableSortedMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableBidiMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testImmutableSortedBidiMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedCollection() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedSortedCollection() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedBag() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedSortedBag() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedSet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedSortedSet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedList() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedSortedMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedBidiMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testTypedSortedBidiMap() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

   /* public function testPerformance(){
        $timer = new \blaze\util\Timer();
        $list = new lists\ArrayList();
        for($i=0;$i<50000;$i++){
            $list->add(new \blaze\lang\Integer($i));
        }
        $timer->start();
        $ar = $list->toArray();
        $ret = \array_search(new \blaze\lang\Integer(40000), $ar);
       $time = $timer->stop();
       echo $time.'   '.$ret.PHP_EOL;

       $timer->start();
       Collections::binarySearch($list, new \blaze\lang\Integer(4000));
       $time = $timer->stop();
       echo $time.'   '.$ret.PHP_EOL;


    }*/

}
/*class IntComperator implements Comparator{

public function compare(Object $o1, Object $o2) {
        if($o1 instanceof  Integer && $o2 instanceof  Integer){
            $ret =  $o2->toNative() - $o1->toNative();
            if($ret === 0){
                return 0;
            }
            if($ret>0){
                return 1;
            }
            if($ret<0){
                return -1;
            }
        }
    }
}*/

?>