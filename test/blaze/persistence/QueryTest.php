<?php

namespace blaze\persistence;

/**
 * This is currently not working, because the tokenization of queries is not yet implemented.
 *
 * Test class for PersistenceConfigurationTest.
 * Generated by PHPUnit on 2010-08-31 at 23:54:33.
 */
class QueryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var blaze\persistence\cfg\Configuration
     */
    protected $stmt;


    protected function setUp() {
        
    }

    protected function tearDown() {

    }

    public function testQuery(){
//        $this->stmt = query\QueryTokenizer::createStatement('SELECT u FROM User u Where u.userId = 123.132');
//        $this->stmt = query\QueryTokenizer::createStatement('SELECT SUM(u.person.age.digits.first), AVG(u.age) FROM User u');
//        $this->stmt = query\QueryTokenizer::createStatement('SELECT u.person.father.person.father.name FROM User u WHERE u.name = \'Testname\'');
//        $this->stmt = query\QueryTokenizer::createStatement('FROM User u, Groups g WHERE g.groupId = 1 AND g IN (u.groups)');
//        $this->stmt = query\QueryTokenizer::createStatement('FROM User u WHERE u.registered BETWEEN :fromDate AND :toDate AND u.groups.count != 0 AND !u.locked');
//        $this->stmt = query\QueryTokenizer::createStatement('FROM User u GROUP BY u.groups WHERE u.person IS NOT NULL AND u IN (SELECT grp.users FROM Group AS grp WHERE grp.users.count > 10)');
//        $this->stmt = query\QueryTokenizer::createStatement('FROM User u Order by u.registered');
//        $this->stmt = query\QueryTokenizer::createStatement('UPDATE User u Set u.name = u.name + \' \' +? WHERE u.userId = 3 OR u.userName LIKE \'ad%n\'');
//        $this->stmt = query\QueryTokenizer::createStatement('DELETE FROM User u Where u EXISTS(SELECT grp.users FROM Group grp Where grp.users.count > grp.allowedMembers)');
//        $this->stmt = query\QueryTokenizer::createStatement('FROM User u JOIN Permissions perm WITH perm.module IS NOT NULL JOIN Property JOIN PropertyClass');

    }
}

?>
