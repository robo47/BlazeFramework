<?php

namespace blaze\ds;

use blaze\ds\meta\ColumnMetaData,
 blaze\ds\CallableStatement
        \PDO;

require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/Reflectable.php';
require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/Object.php';
require_once 'D:/xampp/htdocs/BlazeFrameworkServer/src/blaze/lang/ClassLoader.php';
spl_autoload_register('blaze\lang\ClassLoader::autoLoad');
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../../src/blaze/ds/DataSourceManager.php';

/**
 * Test class for the whole ds Package!
 * Generated by PHPUnit on 2010-08-09 at 19:15:34.
 */
//MetaDatenTEst NotNull sollte leeres array sein!
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
     * @var Strin/SQL
     */
    protected $sqlstmt = array();

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        //bdsc:<driver-name>://<Host>[:Port][/DB][?UID=User][&PWD=Password][&Option=Value]..

        $this->bdsc[0] = 'bdsc:pdomysql://localhost:3306/test?UID=root';
    }

    /**
     * Tears down the fixture, for example, closesd a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());
            $this->con[$i]->close();
            $this->assertTrue($this->con[$i]->isClosed());
        }
    }

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
    }

    /**
     * Begin Test DataSourceManager
     */
    public function testSelectStatement() {
        // Remove the following lines when you implement this test.
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());
            $stm = $this->con[$i]->createStatement();
            $this->assertNotNull($stm);

            $rs = $stm->executeQuery('Select datum,zahl,zeichen,geld  from test');

            while ($rs->next()) {
                $rs->getDate(0);
                $rs->getInt(1);
                $rs->getString(2);
                $rs->getDouble(3);
            }
        }
    }

    public function testInsertStatement() {
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());

            $this->con[$i]->beginTransaction();

            $stm = $this->con[$i]->createStatement();
            $this->assertNotNull($stm);

            $this->assertNotNull(($rs = $stm->executeQuery('Select MAX(zahl) from test')));
            $this->assertTrue(($rs->next()));
                $max = $rs->getInt(0);
            
            $max++;



            $stm = $this->con[$i]->createStatement();
            $ret = $stm->executeUpdate('INSERT INTO test (zahl, zeichen, datum, geld) VALUES (' . $max . ', \'Stmt' . $max . '\', \'2010-08-28\', \'1.04\')');


            $this->con[$i]->commit();
            $this->assertEquals(1, $ret);

            $stm = $this->con[$i]->createStatement();
            $rs = $stm->executeQuery('Select zahl from test where zahl = ' . $max);
            while ($rs->next()) {
                $this->assertTrue($rs->getInt(0) == $max);
            }
        }
    }

    public function testSelectPreparedStatement() {
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());
            $stm = $this->con[$i]->prepareStatement('Select datum,zahl,zeichen,geld  from test');
            $this->assertNotNull($stm);


            $rs = $stm->executeQuery();

            while ($rs->next()) {
                $rs->getDate(0);
                $this->assertNotNull($rs->getInt(1));
                $rs->getString(2);
                $rs->getDouble(3);
            }
        }
    }

    public function testInsertPreparedStatement() {
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());

            $this->con[$i]->beginTransaction();

            $stm = $this->con[$i]->prepareStatement('INSERT INTO test (zahl ,zeichen ,datum ,geld) VALUES (?,?,?,?)');
            $this->assertNotNull($stm);

            $maxstm = $this->con[$i]->createStatement();
            $rs = $maxstm->executeQuery('Select MAX(zahl) from test');
            while ($rs->next()) {
                $max = $rs->getInt(0);
            }
            $max++;

            $stm->setInt(0, $max);
            $stm->setString(1, 'PreStmTest' . $max);
            $stm->setDate(2, new \blaze\util\Date(2010, 02, $max));
            $stm->setDouble(3, 0.45);

            $ret = $stm->executeUpdate();

            $this->con[$i]->commit();

            $this->assertEquals(1, $ret);

            $stm = $this->con[$i]->createStatement();
            $rs = $stm->executeQuery('Select zahl from test where zahl = ' . $max);
            while ($rs->next()) {

                $this->assertTrue($rs->getInt(0) == $max);
            }
        }
    }

    public function testRollbackPreparedStatement() {
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());



            $maxstm = $this->con[$i]->createStatement();
            $rs = $maxstm->executeQuery('Select MAX(zahl) from test');
            while ($rs->next()) {
                $max = $rs->getInt(0);
            }
            $max++;

            $this->con[$i]->setAutoCommit(false);

            $this->con[$i]->beginTransaction();
            $stm = $this->con[$i]->prepareStatement('INSERT INTO test (zahl ,zeichen ,datum ,geld) VALUES (?,?,?,?)');
            $this->assertNotNull($stm);
            $stm->setInt(0, $max);
            $stm->setString(1, 'PreStmRollback' . $max);
            $stm->setDate(2, new \blaze\util\Date(2010, 02, $max));
            $stm->setDouble(3, 0.45);

            $ret = $stm->executeUpdate();

            $this->assertEquals(1, $ret);
            $this->con[$i]->rollback();

            $stm = $this->con[$i]->createStatement();
            $rs = $stm->executeQuery('Select zahl from test where zahl = ' . $max);

            $this->assertFalse($rs->next());
        }
    }

    public function testMetaData() {
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());

            $meta = $this->con[$i]->getMetaData();

            $strar = split(':', $this->bdsc[$i]);
            $strar[2] = \trim($strar[2], '//');
            $strar[3] = split('/', $strar[3]);
            $strar[3][1] = split('\?', $strar[3][1]);

            $this->assertTrue($meta->getConnection() == $this->con[$i]);
            $this->assertTrue($meta->getDatabaseName() == $strar[3][1][0]);
            $this->assertTrue($meta->getHost() == $strar[2]);
            $this->assertTrue($meta->getPort() == $strar[3][0]);

            $this->assertNotNull($meta->getSchemas());
            $schema = $meta->getSchema($strar[3][1][0]);
            $this->assertNotNull($schema);
            $this->assertTrue($schema->getDatabaseMetaData()==$meta);

            $this->schemaTest($schema);
           
 
        }
    }

    public function schemaTest(meta\SchemaMetaData $schema){

        $this->assertNotNull($schema->getSchemaCharset());
        $this->assertNotNull($schema->getSchemaCollation());
        $this->assertNotNull($schema->getSchemaName());
        $this->assertNotNull($schema->getTables());

        $table = $schema->getTable('test');
        $this->assertNotNull($table);

        $this->tableTest($table);
    }

    public function tableTest(meta\TableMetaData $table){
        $this->assertNotNull($table->getColumns());
        $this->assertNotNull($table->getTableCharset());
        $this->assertNotNull($table->getTableCollation());
        $this->assertNotNull($table->getTableName());
        $this->assertNotNull($table->getForeignKeys());
        $this->assertNotNull($table->getPrimaryKeys());
        $this->assertNotNull($table->getUniqueKeys());

        $col = $table->getColumn('zahl');
        $this->assertNotNull($col);




    }
    

    public function testResultSet() {
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());
            $stm = $this->con[$i]->prepareStatement('Select tblob, tbool, tdate, tdecimal, tdouble, tfloat, tstring, tint from testall');
            $this->assertNotNull($stm);


            $rs = $stm->executeQuery();

            while ($rs->next()) {
                $this->assertNotNull($rs->getBlob(0));
                $this->assertNotNull($rs->getBoolean(1));
                $this->assertNotNull($rs->getDate(2));
                $this->assertNotNull($rs->getDecimal(3));
                $this->assertNotNull($rs->getDouble(4));
                $this->assertNotNull($rs->getFloat(5));
                $this->assertNotNull($rs->getString(6));
                $this->assertNotNull($rs->getInt(7));
            }

            $this->assertTrue($rs->relative(-1));
            $this->assertFalse($rs->isClosed());
            $rs->close();
            $this->assertTrue($rs->isClosed());
        }
    }

    public function testBatch(){
         $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());

           

            $stm = $this->con[$i]->createStatement();
            $this->assertNotNull($stm);

            $rs = $stm->executeQuery('Select MAX(zahl) from test');
            while ($rs->next()) {
                $max = $rs->getInt(0);
            }
            $max++;



            $stm = $this->con[$i]->createStatement();
            $ret = $stm->addBatch('INSERT INTO test (zahl, zeichen, datum, geld) VALUES (' . $max . ', \'Batch' . $max . '\', \'2010-08-28\', \'1.04\');');
            $max++;
            $ret = $stm->addBatch('INSERT INTO test (zahl, zeichen, datum, geld) VALUES (' . $max . ', \'Batch' . $max . '\', \'2010-08-28\', \'1.04\');');
            $max++;
            $ret = $stm->addBatch('INSERT INTO test (zahl, zeichen, datum, geld) VALUES (' . $max . ', \'Batch' . $max . '\', \'2010-08-28\', \'1.04\');');

           


            $ret = $stm->executeBatch();
            

            $stm = $this->con[$i]->createStatement();
            $rs = $stm->executeQuery('Select zahl from test where zahl <= '.$max.' and zahl>='.($max-2));
            $max = $max-2;
            while ($rs->next()) {
                $this->assertTrue($rs->getInt(0)==$max);
                $max++;
            }
        }
    }

    public function testCallableStatement(){
        $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
           $stm = $this->con[$i]->prepareCall('CALL counttest(@ret)');
           $stm->execute();
           $ret = $stm->getInt('ret');


           $this->assertNotNull($ret);

           $stm = $this->con[$i]->prepareCall('CALL getdatebyzahl(?,@ret)');
           $stm->setInt(0,new \blaze\lang\Integer(1));
           $stm->execute();
           $ret = $stm->getDate('ret');
           $this->assertNotNull($ret);

           $stm = $this->con[$i]->prepareCall('SELECT functiontest(?) into @a');
           $stm->setInt(0,new \blaze\lang\Integer(1));
           $stm->execute();
           $ret = $stm->getInt('a');
           

        }

    }

    public function testView(){
         $this->setupConnection();

        for ($i = 0; $i < (count($this->con)); $i++) {
            $this->assertFalse($this->con[$i]->isClosed());
            $stm = $this->con[$i]->prepareStatement('Select zahl,datum from v1');
            $this->assertNotNull($stm);


            $rs = $stm->executeQuery();

            while ($rs->next()) {
                $rs->getDate(1);
                $this->assertNotNull($rs->getInt(0));
            }
        }

    }

}
?>
