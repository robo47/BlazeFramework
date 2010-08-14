<?php

namespace blaze\web\el;

require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/Reflectable.php';
require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/Object.php';
require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../../../src/blaze/web/el/ELResolver.php';

class Test extends \blaze\lang\Object {

    private $name;
    private $label;
    private $value;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

}

class Meta extends \blaze\lang\Object {

    private $name;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

}

/**
 * Test class for ELResolver.
 * Generated by PHPUnit on 2010-08-05 at 10:14:27.
 */
class ELResolverTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ELResolver
     */
    protected $object;
    protected $mapper;
    protected $bCtx;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $test1 = new Test();
        $test1->setLabel(true);
        $test1->setName(10);
        $test1->setValue('MyValue1');

        $test2 = new Test();
        $test2->setLabel('MyLabel2');
        $test2->setName('value');
        $test2->setValue($test1);

        $test3 = new Test();
        $test3->setLabel('label');
        $test3->setName($test1);
        $test3->setValue('name');

        $netApp = \blazeServer\source\netlet\NetletApplication::getAdminApplication();
        $netlets = $netApp->getNetletContext()->getNetlets();
        \ob_start();
        $app = $netlets['BlazeNetlet']->getClass()->getField('application')->get($netlets['BlazeNetlet']);
        $this->bCtx = new \blaze\web\application\BlazeContext($app, new \blazeServer\source\netlet\http\HttpNetletRequestImpl(), new \blazeServer\source\netlet\http\HttpNetletResponseImpl());
        \ob_clean();
        
        $this->bCtx = \blaze\web\application\BlazeContext::getCurrentInstance();
        $this->bCtx->getELContext()->setContext(ELContext::SCOPE_REQUEST, new scope\ELRequestScopeContext(array()));
        $this->bCtx->getELContext()->getContext(ELContext::SCOPE_REQUEST)->set($this->bCtx, 'test1', $test1);
        $this->bCtx->getELContext()->getContext(ELContext::SCOPE_REQUEST)->set($this->bCtx, 'test2', $test2);
        $this->bCtx->getELContext()->getContext(ELContext::SCOPE_REQUEST)->set($this->bCtx, 'test3', $test3);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    public function testGetValue() {
        // Resolving
        $this->assertEquals('label', Expression::create('{test3.label}')->getValue($this->bCtx));
        $this->assertEquals('MyValue1', Expression::create('{test3.name.value}')->getValue($this->bCtx));
        $this->assertEquals('MyLabel2', Expression::create('{test2.{test3.label}}')->getValue($this->bCtx));
        $this->assertEquals('MyValue1', Expression::create('{test1.{test2.{test3.value}}}')->getValue($this->bCtx));
        $this->assertEquals('ASD MyValue1 BLA', Expression::create('ASD {test1.{test2.{test3.value}}} BLA')->getValue($this->bCtx));

        // Arithmetic
        $this->assertEquals(12, Expression::create('{test1.name + 2}')->getValue($this->bCtx));
        $this->assertEquals(8, Expression::create('{test1.name - 2}')->getValue($this->bCtx));
        $this->assertEquals(20, Expression::create('{test1.name * 2}')->getValue($this->bCtx));
        $this->assertEquals(5, Expression::create('{test1.name / 2}')->getValue($this->bCtx));
        $this->assertEquals(0, Expression::create('{test1.name % 2}')->getValue($this->bCtx));
        $this->assertTrue(Expression::create('{test1.name > 2}')->getValue($this->bCtx));
        $this->assertTrue(Expression::create('{test1.name < 20}')->getValue($this->bCtx));
        $this->assertTrue(Expression::create('{test1.name >= 10}')->getValue($this->bCtx));
        $this->assertTrue(Expression::create('{test1.name <= 11}')->getValue($this->bCtx));

        //Logical
//        $this->assertTrue(Expression::create('{test1.value == "MyValue1"}')->getValue($this->bCtx));
//        $this->assertTrue(Expression::create('{test1.value != "MyValue2"}')->getValue($this->bCtx));
//        $this->assertTrue(Expression::create('{test1.value != "MyValue2"}')->getValue($this->bCtx));
        $this->assertFalse(Expression::create('{!test1.label}')->getValue($this->bCtx));
        $this->assertFalse(Expression::create('{!true}')->getValue($this->bCtx));
        $this->assertFalse(Expression::create('{empty(test1.value)}')->getValue($this->bCtx));
    }

    public function testSetValue() {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testInvoke() {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
?>
