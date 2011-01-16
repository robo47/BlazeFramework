<<<<<<< HEAD
<?php

namespace blaze\ds;

use blaze\ds\meta\ColumnMetaData,
 blaze\ds\CallableStatement,
 \PDO;

/**
 * This tests all functionalities of the data source package.
 * By adding a new BDSC-Url in setUp() other databases can be tested too.
 * @todo extend this test to use every possible type for columns, getBlob/Clob/NClob on resultset will return stream which should have an native stream but will have a string as content for PHP Version < 5.3.4
 * @todo write a test for callable statement
 * @todo test transaction isolation levels and nested transactions
 * @todo test scrollable ResultSets
 * @todo test multiple resultsets
 * @todo test the metadata
 * @todo test the addXXX() methods to copy a db or parts of it from one server to another
 */
class DataSourceManagerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var DataSourceManager
     */
    protected $dsm = null;
    /**
     * @var bdsc
     */
    protected $bdsc = array();
    /**
     * @var DataSource
     */
    protected $ds = array();
    /**
     * @var Connection
     */
    protected $con = array();
    /**
     * @var Connection
     */
    protected $db = array();

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        //bdsc:<driver-name>://<Host>[:Port][/DB][?UID=User][&PWD=Password][&Option=Value]..

        $this->bdsc[0] = 'bdsc:pdomysql://localhost:3306/test?UID=root';
    }

    /**
     * This sets up connections to the data sources and creates databases
     * which are deleted at the end.
     */
    protected function setupConnection() {
        $this->dsm = DataSourceManager::getInstance();
        $this->assertNotNull($this->dsm);

        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $this->ds[$i] = $this->dsm->getDataSource($this->bdsc[$i]);
            $this->assertNotNull($this->ds[$i]);
        }

        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $this->con[$i] = $this->ds[$i]->getConnection();
            $this->assertNotNull($this->con[$i]);
        }

        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $this->db[$i] = $this->con[$i]->createDatabase('test_db');
            $this->assertNotNull($this->db[$i]);
            $this->assertEquals('test_db', $this->db[$i]->getDatabaseName());
        }
    }

    /**
     * This creates tables in the databases which can all be accessed the same way
     * and changed.
     */
    protected function setupTables() {
        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $schema = $this->db[$i]->createSchema('test_db');

            $tbl1 = $schema->createTable('test_table1');
            $tbl1->setTableComment('test_table2');
            $tbl1->setTableComment('This table is special');
            $tbl1->setTableCharset('latin1');
            $tbl1->setTableCollation('latin1_german1_ci');
            $col = $tbl1->createColumn('col_id', 'int');
            $col->setPrimaryKey(true, 'PK_COL_ID');
            $tbl1->addColumn($col);
            $schema->addTable($tbl1);


            $tbl2 = $schema->createTable('test_table2');
            $tbl2->setTableComment('This table is special too');
            $col = $tbl1->createColumn('col_id', 'blaze\\lang\\String', 10);
            $col->setPrimaryKey(true, 'PK_COL_ID');
            $tbl2->addColumn($col);
            $schema->addTable($tbl2);
        }
    }

    /**
     * Drops all test databases and closes all connections.
     */
    protected function closeConnection() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());
            $this->con[$i]->dropDatabase('test_db');
            $this->con[$i]->close();
            $this->assertTrue($this->con[$i]->isClosed());
        }
    }

    //-------- Normal Statements ----------//

    /**
     * Inserts data with a normal statement with the executeUpdate() method.
     */
    protected function insertDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            for ($i = 0; $i < 26; $i++) {
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table1 VALUES(' . $i . ')'));
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table2 VALUES(\'' . (chr(ord('a') + $i)) . '\')'));
            }
            for ($i = 0; $i < 26; $i++) {
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table1 VALUES(' . ($i + 26) . ')'));
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table2 VALUES(\'' . ('a' . chr(ord('a') + $i)) . '\')'));
            }

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function updateDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $this->assertEquals(52, $stmt->executeUpdate('UPDATE test_table1 SET col_id = col_id + 52'));
            $this->assertEquals(52, $stmt->executeUpdate('UPDATE test_table2 SET col_id = CONCAT(\'Z\', col_id)'));

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Selects data with a normal statement with the executeQuery() method.
     */
    protected function selectDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->createStatement();
            $stmt2 = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $rs1 = $stmt1->executeQuery('SELECT * FROM test_table1 WHERE col_id = ' . $i);
                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $rs2 = $stmt2->executeQuery('SELECT * FROM test_table2 WHERE col_id = \'' . (chr(ord('a') + $i)) . '\'');
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i, $rs1->getInt(0));
                $this->assertEquals(chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }
            for ($i = 0; $i < 26; $i++) {
                $rs1 = $stmt1->executeQuery('SELECT * FROM test_table1 WHERE col_id = ' . ($i + 26));
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $rs2 = $stmt2->executeQuery('SELECT * FROM test_table2 WHERE col_id = \'' . ('a' . chr(ord('a') + $i)) . '\'');
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i + 26, $rs1->getInt(0));
                $this->assertEquals('a' . chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function deleteDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $this->assertEquals(52, $stmt->executeUpdate('DELETE FROM test_table1'));
            $this->assertEquals(52, $stmt->executeUpdate('DELETE FROM test_table2'));

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    //-------- Batch Statements ----------//

    /**
     * Inserts data with a normal statement with the executeBatch() method.
     */
    protected function insertDataBatch() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            for ($i = 0; $i < 26; $i++) {
                $stmt->addBatch('INSERT INTO test_table1 VALUES(' . $i . ');');
                $stmt->addBatch('INSERT INTO test_table2 VALUES(\'' . (chr(ord('a') + $i)) . '\');');
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt->addBatch('INSERT INTO test_table1 VALUES(' . ($i + 26) . ');');
                $stmt->addBatch('INSERT INTO test_table2 VALUES(\'' . ('a' . chr(ord('a') + $i)) . '\');');
            }

            $results = $stmt->executeBatch();
            $this->assertTrue(is_array($results));

            foreach ($results as $result) {
                $this->assertEquals(1, $result);
            }

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function updateDataBatch() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $stmt->addBatch('UPDATE test_table1 SET col_id = col_id + 52;');
            $stmt->addBatch('UPDATE test_table2 SET col_id = CONCAT(\'Z\', col_id);');
            $res = $stmt->executeBatch();
            $this->assertTrue(is_array($res));
            $this->assertEquals(52, $res[0]);
            $this->assertEquals(52, $res[1]);

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function deleteDataBatch() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $stmt->addBatch('DELETE FROM test_table1;');
            $stmt->addBatch('DELETE FROM test_table2;');

            $res = $stmt->executeBatch();
            $this->assertTrue(is_array($res));
            $this->assertEquals(52, $res[0]);
            $this->assertEquals(52, $res[1]);

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    //-------- Prepared Statements Index ----------//

    /**
     * Inserts data with a prepared statement which uses a '?' for the parameters.
     */
    protected function insertDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table1 VALUES(?)');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table2 VALUES(?)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i);
                $stmt2->setString(0, chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i + 26);
                $stmt2->setString(0, 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a '?' for the parameters.
     */
    protected function updateDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table1 SET col_id = col_id + ?');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table2 SET col_id = CONCAT(?, col_id)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            $stmt1->setInt(0, 52);
            $stmt2->setString(0, 'Z');

            $this->assertEquals(52, $stmt1->executeUpdate());
            $this->assertEquals(52, $stmt2->executeUpdate());

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Selects data with a prepared statement with the executeQuery() method.
     */
    protected function selectDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table1 WHERE col_id = ?');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table2 WHERE col_id = ?');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i);
                $stmt2->setString(0, chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertFalse($rs1->isClosed());
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertFalse($rs2->isClosed());
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i, $rs1->getInt(0));
                $this->assertEquals(chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i + 26);
                $stmt2->setString(0, 'a' . chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i + 26, $rs1->getInt(0));
                $this->assertEquals('a' . chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a '?' for the parameters.
     */
    protected function deleteDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table1 WHERE col_id = ?');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table2 WHERE col_id = ?');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);


            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i);
                $stmt2->setString(0, chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i + 26);
                $stmt2->setString(0, 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    //-------- Prepared Statements Named ----------//

    /**
     * Inserts data with a prepared statement which uses a ':id' for the parameters.
     */
    protected function insertDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table1 VALUES(:id)');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table2 VALUES(:id)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i);
                $stmt2->setString('id', chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i + 26);
                $stmt2->setString('id', 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a ':id' for the parameters.
     */
    protected function updateDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table1 SET col_id = col_id + :id');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table2 SET col_id = CONCAT(:id, col_id)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            $stmt1->setInt('id', 52);
            $stmt2->setString('id', 'Z');

            $this->assertEquals(52, $stmt1->executeUpdate());
            $this->assertEquals(52, $stmt2->executeUpdate());

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Selects data with a prepared statement with the executeQuery() method.
     */
    protected function selectDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table1 WHERE col_id = :id');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table2 WHERE col_id = :id');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i);
                $stmt2->setString('id', chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i, $rs1->getInt('col_id'));
                $this->assertEquals(chr(ord('a') + $i), $rs2->getString('col_id')->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i + 26);
                $stmt2->setString('id', 'a' . chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i + 26, $rs1->getInt('col_id'));
                $this->assertEquals('a' . chr(ord('a') + $i), $rs2->getString('col_id')->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a '?' for the parameters.
     */
    protected function deleteDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table1 WHERE col_id = :id');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table2 WHERE col_id = :id');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);


            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i);
                $stmt2->setString('id', chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i + 26);
                $stmt2->setString('id', 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testNormalStatement() {
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataNormal();
        $this->selectDataNormal();
        $this->deleteDataNormal();
        $this->insertDataNormal();
        $this->updateDataNormal();
        $this->closeConnection();
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testBatchStatement() {
        // Need to do this because PHPUnit does something weird..
        set_error_handler(array('blaze\lang\System', 'systemErrorHandler'));
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataBatch();
        $this->selectDataNormal();
        $this->deleteDataBatch();
        $this->insertDataBatch();
        $this->updateDataBatch();
        $this->closeConnection();
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testPreparedStatementIndex() {
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataPreparedIndex();
        $this->selectDataPreparedIndex();
        $this->deleteDataPreparedIndex();
        $this->insertDataPreparedIndex();
        $this->updateDataPreparedIndex();
        $this->closeConnection();
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testPreparedStatementNamed() {
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataPreparedNamed();
        $this->selectDataPreparedNamed();
        $this->deleteDataPreparedNamed();
        $this->insertDataPreparedNamed();
        $this->updateDataPreparedNamed();
        $this->closeConnection();
    }

    /**
     * Begin Test DataSourceManager
     */

    public function testTransaction(){
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataBatch();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->checkCountWithinTestTransaction($i, 52);

            $this->db[$i]->getConnection()->beginTransaction();
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertFalse($stmt->execute('DELETE FROM test_table1'));
            $this->assertEquals(52, $stmt->getUpdateCount());
            $this->checkCountWithinTestTransaction($i, 0);
            $this->db[$i]->getConnection()->rollback();

            $this->checkCountWithinTestTransaction($i, 52);
            
            $this->db[$i]->getConnection()->beginTransaction();
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertFalse($stmt->execute('DELETE FROM test_table1'));
            $this->assertEquals(52, $stmt->getUpdateCount());
            $this->db[$i]->getConnection()->commit();

            $this->checkCountWithinTestTransaction($i, 0);
        }

        $this->closeConnection();
    }

    protected function checkCountWithinTestTransaction($i, $count){
        $stmt = $this->db[$i]->getConnection()->createStatement();
        $this->assertNotNull($stmt);
        $rs = $stmt->executeQuery('SELECT COUNT(*) FROM test_table1');
        $this->assertNotNull($rs);
        $this->assertTrue($rs->next());
        $this->assertEquals($count, $rs->getInt(0));

        $rs->close();
        $this->assertTrue($rs->isClosed());
        $stmt->close();
        $this->assertTrue($stmt->isClosed());
    }


//    public function testMetaData() {
//        $this->setupConnection();
//
//        for ($i = 0; $i < (count($this->con)); $i++) {
//            $this->assertFalse($this->con[$i]->isClosed());
//
//            $meta = $this->con[$i]->getMetaData();
//
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$READ_COMMITTED).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$SERIALIZABLE).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$READ_UNCOMMITTED).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$REPEATABLE).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//
//            $strar = split(':', $this->bdsc[$i]);
//            $strar[2] = \trim($strar[2], '//');
//            $strar[3] = split('/', $strar[3]);
//            $strar[3][1] = split('\?', $strar[3][1]);
//
//            $this->assertTrue($meta->getConnection() == $this->con[$i]);
//            $this->assertTrue($meta->getDatabaseName() == $strar[3][1][0]);
//            $this->assertTrue($meta->getHost() == $strar[2]);
//            $this->assertTrue($meta->getPort() == $strar[3][0]);
//
//            $schemas = $meta->getSchemas();
//            $this->assertTrue(\is_array($schemas)&& $schemas[0] instanceof meta\SchemaMetaData);
//            $schema = $meta->getSchema($strar[3][1][0]);
//            $this->assertTrue($schema instanceof meta\SchemaMetaData && $schema !=null);
//            $this->assertTrue($schema->getDatabaseMetaData()==$meta);
//
//            $this->schemaTest($schema);
//
//
//        }
//    }
//    
//    public function testCallableStatement(){
//        $this->setupConnection();
//
//        for ($i = 0; $i < (count($this->con)); $i++) {
//           $stm = $this->con[$i]->prepareCall('CALL counttest(@ret)');
//           $stm->execute();
//           $ret = $stm->getInt('ret');
//
//
//           $this->assertNotNull($ret);
//
//           $stm = $this->con[$i]->prepareCall('CALL getdatebyzahl(?,@ret)');
//           $stm->setInt(0,new \blaze\lang\Integer(1));
//           $stm->execute();
//           $ret = $stm->getDate('ret');
//           $this->assertNotNull($ret);
//
//           $stm = $this->con[$i]->prepareCall('SELECT functiontest(?) into @a');
//           $stm->setInt(0,new \blaze\lang\Integer(1));
//           $stm->execute();
//           $ret = $stm->getInt('a');
//
//
//        }
//
//    }
}

?>
=======
<?php

namespace blaze\ds;

use blaze\ds\meta\ColumnMetaData,
 blaze\ds\CallableStatement,
 \PDO;

/**
 * This tests all functionalities of the data source package.
 * By adding a new BDSC-Url in setUp() other databases can be tested too.
 * @todo extend this test to use every possible type for columns, getBlob/Clob/NClob on resultset will return stream which should have an native stream but will have a string as content for PHP Version < 5.3.4
 * @todo write a test for callable statement
 * @todo test transaction isolation levels and nested transactions
 * @todo test scrollable ResultSets
 * @todo test multiple resultsets
 * @todo test the metadata
 * @todo test the addXXX() methods to copy a db or parts of it from one server to another
 */
class DataSourceManagerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var DataSourceManager
     */
    protected $dsm = null;
    /**
     * @var bdsc
     */
    protected $bdsc = array();
    /**
     * @var DataSource
     */
    protected $ds = array();
    /**
     * @var Connection
     */
    protected $con = array();
    /**
     * @var Connection
     */
    protected $db = array();

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        //bdsc:<driver-name>://<Host>[:Port][/DB][?UID=User][&PWD=Password][&Option=Value]..

        $this->bdsc[0] = 'bdsc:pdomysql://localhost:3306/test?UID=root';
    }

    /**
     * This sets up connections to the data sources and creates databases
     * which are deleted at the end.
     */
    protected function setupConnection() {
        $this->dsm = DataSourceManager::getInstance();
        $this->assertNotNull($this->dsm);

        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $this->ds[$i] = $this->dsm->getDataSource($this->bdsc[$i]);
            $this->assertNotNull($this->ds[$i]);
        }

        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $this->con[$i] = $this->ds[$i]->getConnection();
            $this->assertNotNull($this->con[$i]);
        }

        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $this->db[$i] = $this->con[$i]->createDatabase('test_db');
            $this->assertNotNull($this->db[$i]);
            $this->assertEquals('test_db', $this->db[$i]->getDatabaseName());
        }
    }

    /**
     * This creates tables in the databases which can all be accessed the same way
     * and changed.
     */
    protected function setupTables() {
        for ($i = 0; $i < (count($this->bdsc)); $i++) {
            $schema = $this->db[$i]->createSchema('test_db');

            $tbl1 = $schema->createTable('test_table1');
            $tbl1->setTableComment('test_table2');
            $tbl1->setTableComment('This table is special');
            $tbl1->setTableCharset('latin1');
            $tbl1->setTableCollation('latin1_german1_ci');
            $col = $tbl1->createColumn('col_id', 'int');
            $col->setPrimaryKey(true, 'PK_COL_ID');
            $tbl1->addColumn($col);
            $schema->addTable($tbl1);


            $tbl2 = $schema->createTable('test_table2');
            $tbl2->setTableComment('This table is special too');
            $col = $tbl1->createColumn('col_id', 'blaze\\lang\\String', 10);
            $col->setPrimaryKey(true, 'PK_COL_ID');
            $tbl2->addColumn($col);
            $schema->addTable($tbl2);
        }
    }

    /**
     * Drops all test databases and closes all connections.
     */
    protected function closeConnection() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());
            $this->con[$i]->dropDatabase('test_db');
            $this->con[$i]->close();
            $this->assertTrue($this->con[$i]->isClosed());
        }
    }

    //-------- Normal Statements ----------//

    /**
     * Inserts data with a normal statement with the executeUpdate() method.
     */
    protected function insertDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            for ($i = 0; $i < 26; $i++) {
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table1 VALUES(' . $i . ')'));
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table2 VALUES(\'' . (chr(ord('a') + $i)) . '\')'));
            }
            for ($i = 0; $i < 26; $i++) {
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table1 VALUES(' . ($i + 26) . ')'));
                $this->assertEquals(1, $stmt->executeUpdate('INSERT INTO test_table2 VALUES(\'' . ('a' . chr(ord('a') + $i)) . '\')'));
            }

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function updateDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $this->assertEquals(52, $stmt->executeUpdate('UPDATE test_table1 SET col_id = col_id + 52'));
            $this->assertEquals(52, $stmt->executeUpdate('UPDATE test_table2 SET col_id = CONCAT(\'Z\', col_id)'));

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Selects data with a normal statement with the executeQuery() method.
     */
    protected function selectDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->createStatement();
            $stmt2 = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $rs1 = $stmt1->executeQuery('SELECT * FROM test_table1 WHERE col_id = ' . $i);
                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $rs2 = $stmt2->executeQuery('SELECT * FROM test_table2 WHERE col_id = \'' . (chr(ord('a') + $i)) . '\'');
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i, $rs1->getInt(0));
                $this->assertEquals(chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }
            for ($i = 0; $i < 26; $i++) {
                $rs1 = $stmt1->executeQuery('SELECT * FROM test_table1 WHERE col_id = ' . ($i + 26));
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $rs2 = $stmt2->executeQuery('SELECT * FROM test_table2 WHERE col_id = \'' . ('a' . chr(ord('a') + $i)) . '\'');
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i + 26, $rs1->getInt(0));
                $this->assertEquals('a' . chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function deleteDataNormal() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $this->assertEquals(52, $stmt->executeUpdate('DELETE FROM test_table1'));
            $this->assertEquals(52, $stmt->executeUpdate('DELETE FROM test_table2'));

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    //-------- Batch Statements ----------//

    /**
     * Inserts data with a normal statement with the executeBatch() method.
     */
    protected function insertDataBatch() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            for ($i = 0; $i < 26; $i++) {
                $stmt->addBatch('INSERT INTO test_table1 VALUES(' . $i . ');');
                $stmt->addBatch('INSERT INTO test_table2 VALUES(\'' . (chr(ord('a') + $i)) . '\');');
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt->addBatch('INSERT INTO test_table1 VALUES(' . ($i + 26) . ');');
                $stmt->addBatch('INSERT INTO test_table2 VALUES(\'' . ('a' . chr(ord('a') + $i)) . '\');');
            }

            $results = $stmt->executeBatch();
            $this->assertTrue(is_array($results));

            foreach ($results as $result) {
                $this->assertEquals(1, $result);
            }

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function updateDataBatch() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $stmt->addBatch('UPDATE test_table1 SET col_id = col_id + 52;');
            $stmt->addBatch('UPDATE test_table2 SET col_id = CONCAT(\'Z\', col_id);');
            $res = $stmt->executeBatch();
            $this->assertTrue(is_array($res));
            $this->assertEquals(52, $res[0]);
            $this->assertEquals(52, $res[1]);

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    /**
     * Updates data with a normal statement with the executeUpdate() method.
     */
    protected function deleteDataBatch() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertNotNull($stmt);

            $stmt->addBatch('DELETE FROM test_table1;');
            $stmt->addBatch('DELETE FROM test_table2;');

            $res = $stmt->executeBatch();
            $this->assertTrue(is_array($res));
            $this->assertEquals(52, $res[0]);
            $this->assertEquals(52, $res[1]);

            $stmt->close();
            $this->assertTrue($stmt->isClosed());
        }
    }

    //-------- Prepared Statements Index ----------//

    /**
     * Inserts data with a prepared statement which uses a '?' for the parameters.
     */
    protected function insertDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table1 VALUES(?)');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table2 VALUES(?)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i);
                $stmt2->setString(0, chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i + 26);
                $stmt2->setString(0, 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a '?' for the parameters.
     */
    protected function updateDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table1 SET col_id = col_id + ?');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table2 SET col_id = CONCAT(?, col_id)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            $stmt1->setInt(0, 52);
            $stmt2->setString(0, 'Z');

            $this->assertEquals(52, $stmt1->executeUpdate());
            $this->assertEquals(52, $stmt2->executeUpdate());

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Selects data with a prepared statement with the executeQuery() method.
     */
    protected function selectDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table1 WHERE col_id = ?');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table2 WHERE col_id = ?');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i);
                $stmt2->setString(0, chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertFalse($rs1->isClosed());
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertFalse($rs2->isClosed());
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i, $rs1->getInt(0));
                $this->assertEquals(chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i + 26);
                $stmt2->setString(0, 'a' . chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i + 26, $rs1->getInt(0));
                $this->assertEquals('a' . chr(ord('a') + $i), $rs2->getString(0)->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a '?' for the parameters.
     */
    protected function deleteDataPreparedIndex() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table1 WHERE col_id = ?');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table2 WHERE col_id = ?');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);


            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i);
                $stmt2->setString(0, chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt(0, $i + 26);
                $stmt2->setString(0, 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    //-------- Prepared Statements Named ----------//

    /**
     * Inserts data with a prepared statement which uses a ':id' for the parameters.
     */
    protected function insertDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table1 VALUES(:id)');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('INSERT INTO test_table2 VALUES(:id)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i);
                $stmt2->setString('id', chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i + 26);
                $stmt2->setString('id', 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a ':id' for the parameters.
     */
    protected function updateDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table1 SET col_id = col_id + :id');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('UPDATE test_table2 SET col_id = CONCAT(:id, col_id)');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            $stmt1->setInt('id', 52);
            $stmt2->setString('id', 'Z');

            $this->assertEquals(52, $stmt1->executeUpdate());
            $this->assertEquals(52, $stmt2->executeUpdate());

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Selects data with a prepared statement with the executeQuery() method.
     */
    protected function selectDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table1 WHERE col_id = :id');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('SELECT * FROM test_table2 WHERE col_id = :id');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);

            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i);
                $stmt2->setString('id', chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i, $rs1->getInt('col_id'));
                $this->assertEquals(chr(ord('a') + $i), $rs2->getString('col_id')->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i + 26);
                $stmt2->setString('id', 'a' . chr(ord('a') + $i));
                $rs1 = $stmt1->executeQuery();
                $rs2 = $stmt2->executeQuery();

                $this->assertNotNull($rs1);
                $this->assertEquals($rs1, $stmt1->getResultSet());
                $this->assertNotNull($rs2);
                $this->assertEquals($rs2, $stmt2->getResultSet());

                $this->assertTrue($rs1->next());
                $this->assertTrue($rs2->next());
                $this->assertEquals($i + 26, $rs1->getInt('col_id'));
                $this->assertEquals('a' . chr(ord('a') + $i), $rs2->getString('col_id')->toNative());

                $rs1->close();
                $rs2->close();
                $this->assertTrue($rs1->isClosed());
                $this->assertTrue($rs2->isClosed());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * Updates data with a prepared statement which uses a '?' for the parameters.
     */
    protected function deleteDataPreparedNamed() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $stmt1 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table1 WHERE col_id = :id');
            $stmt2 = $this->db[$i]->getConnection()->prepareStatement('DELETE FROM test_table2 WHERE col_id = :id');
            $this->assertNotNull($stmt1);
            $this->assertNotNull($stmt2);


            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i);
                $stmt2->setString('id', chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }
            for ($i = 0; $i < 26; $i++) {
                $stmt1->setInt('id', $i + 26);
                $stmt2->setString('id', 'a' . chr(ord('a') + $i));

                $this->assertEquals(1, $stmt1->executeUpdate());
                $this->assertEquals(1, $stmt2->executeUpdate());
            }

            $stmt1->close();
            $stmt2->close();
            $this->assertTrue($stmt1->isClosed());
            $this->assertTrue($stmt2->isClosed());
        }
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testNormalStatement() {
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataNormal();
        $this->selectDataNormal();
        $this->deleteDataNormal();
        $this->insertDataNormal();
        $this->updateDataNormal();
        $this->closeConnection();
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testBatchStatement() {
        // Need to do this because PHPUnit does something weird..
        set_error_handler(array('blaze\lang\System', 'systemErrorHandler'));
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataBatch();
        $this->selectDataNormal();
        $this->deleteDataBatch();
        $this->insertDataBatch();
        $this->updateDataBatch();
        $this->closeConnection();
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testPreparedStatementIndex() {
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataPreparedIndex();
        $this->selectDataPreparedIndex();
        $this->deleteDataPreparedIndex();
        $this->insertDataPreparedIndex();
        $this->updateDataPreparedIndex();
        $this->closeConnection();
    }

    /**
     * This tests the functionality of a simple statement with the precondition
     * that the test_table was created.
     */
    public function testPreparedStatementNamed() {
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataPreparedNamed();
        $this->selectDataPreparedNamed();
        $this->deleteDataPreparedNamed();
        $this->insertDataPreparedNamed();
        $this->updateDataPreparedNamed();
        $this->closeConnection();
    }

    /**
     * Begin Test DataSourceManager
     */

    public function testTransaction(){
        $this->setupConnection();
        $this->setupTables();
        $this->insertDataBatch();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->checkCountWithinTestTransaction($i, 52);

            $this->db[$i]->getConnection()->beginTransaction();
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertFalse($stmt->execute('DELETE FROM test_table1'));
            $this->assertEquals(52, $stmt->getUpdateCount());
            $this->checkCountWithinTestTransaction($i, 0);
            $this->db[$i]->getConnection()->rollback();

            $this->checkCountWithinTestTransaction($i, 52);
            
            $this->db[$i]->getConnection()->beginTransaction();
            $stmt = $this->db[$i]->getConnection()->createStatement();
            $this->assertFalse($stmt->execute('DELETE FROM test_table1'));
            $this->assertEquals(52, $stmt->getUpdateCount());
            $this->db[$i]->getConnection()->commit();

            $this->checkCountWithinTestTransaction($i, 0);
        }

        $this->closeConnection();
    }

    protected function checkCountWithinTestTransaction($i, $count){
        $stmt = $this->db[$i]->getConnection()->createStatement();
        $this->assertNotNull($stmt);
        $rs = $stmt->executeQuery('SELECT COUNT(*) FROM test_table1');
        $this->assertNotNull($rs);
        $this->assertTrue($rs->next());
        $this->assertEquals($count, $rs->getInt(0));

        $rs->close();
        $this->assertTrue($rs->isClosed());
        $stmt->close();
        $this->assertTrue($stmt->isClosed());
    }


//    public function testMetaData() {
//        $this->setupConnection();
//
//        for ($i = 0; $i < (count($this->con)); $i++) {
//            $this->assertFalse($this->con[$i]->isClosed());
//
//            $meta = $this->con[$i]->getMetaData();
//
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$READ_COMMITTED).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$SERIALIZABLE).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$READ_UNCOMMITTED).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//            $this->con[$i]->setTransactionIsolation(\blaze\ds\driver\pdomysql\IsolationLevel::$REPEATABLE).\PHP_EOL;
//            echo $this->con[$i]->getTransactionIsolation();
//
//            $strar = split(':', $this->bdsc[$i]);
//            $strar[2] = \trim($strar[2], '//');
//            $strar[3] = split('/', $strar[3]);
//            $strar[3][1] = split('\?', $strar[3][1]);
//
//            $this->assertTrue($meta->getConnection() == $this->con[$i]);
//            $this->assertTrue($meta->getDatabaseName() == $strar[3][1][0]);
//            $this->assertTrue($meta->getHost() == $strar[2]);
//            $this->assertTrue($meta->getPort() == $strar[3][0]);
//
//            $schemas = $meta->getSchemas();
//            $this->assertTrue(\is_array($schemas)&& $schemas[0] instanceof meta\SchemaMetaData);
//            $schema = $meta->getSchema($strar[3][1][0]);
//            $this->assertTrue($schema instanceof meta\SchemaMetaData && $schema !=null);
//            $this->assertTrue($schema->getDatabaseMetaData()==$meta);
//
//            $this->schemaTest($schema);
//
//
//        }
//    }
//    
//    public function testCallableStatement(){
//        $this->setupConnection();
//
//        for ($i = 0; $i < (count($this->con)); $i++) {
//           $stm = $this->con[$i]->prepareCall('CALL counttest(@ret)');
//           $stm->execute();
//           $ret = $stm->getInt('ret');
//
//
//           $this->assertNotNull($ret);
//
//           $stm = $this->con[$i]->prepareCall('CALL getdatebyzahl(?,@ret)');
//           $stm->setInt(0,new \blaze\lang\Integer(1));
//           $stm->execute();
//           $ret = $stm->getDate('ret');
//           $this->assertNotNull($ret);
//
//           $stm = $this->con[$i]->prepareCall('SELECT functiontest(?) into @a');
//           $stm->setInt(0,new \blaze\lang\Integer(1));
//           $stm->execute();
//           $ret = $stm->getInt('a');
//
//
//        }
//
//    }
}

?>
>>>>>>> 30908ff908011e6657fa44fbda73dc71056c40b0
