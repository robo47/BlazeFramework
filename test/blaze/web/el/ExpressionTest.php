<?php

namespace blaze\web\el;

class ExpressionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Expression
     */
    protected $singleSimpleExp;
    /**
     * @var Expression
     */
    protected $multipleSimpleExp;
    /**
     * @var Expression
     */
    protected $singleNestedExp;
    /**
     * @var Expression
     */
    protected $multipleNestedExp;
    /**
     * @var Expression
     */
    protected $wrongExp;

    protected function setUp() {
        $this->singleSimpleExp = new Expression('some text which gets concated {test.expression.value} and this too');
        $this->multipleSimpleExp = new Expression('now a {words[en][more]} complicated {words[de][example]} which should be {words.latestUsed}');
        $this->singleNestedExp = new Expression('oh ?? {myNut.does.not{know.{exact.name}}.but.can.handle{object.this}} nesting o.O');
        $this->multipleNestedExp = new Expression('yeah {asd{bsd.fgh.{xcvb.er}}.wonder} look {boring.{stuff.importance}} even {entry.{column.key}} multiple');
        $this->wrongExp = new Expression('open but no close? }{asfasfdasdf.{asdfasfd');
    }


    protected function tearDown() {

    }

    public function testIsExpression() {
        $this->assertTrue(Expression::isExpression('{sdfg}'));
        $this->assertTrue(Expression::isExpression('asfd{sdfg}asdfasdf'));
        $this->assertFalse(Expression::isExpression('}sfd{sdfgasdfasdf'));
    }

    public function testIsValid() {
        $this->assertTrue($this->singleSimpleExp->isValid());
        $this->assertTrue($this->singleNestedExp->isValid());
        $this->assertTrue($this->multipleSimpleExp->isValid());
        $this->assertTrue($this->multipleNestedExp->isValid());
        $this->assertFalse($this->wrongExp->isValid());
    }

}
?>
