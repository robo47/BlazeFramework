<?php
namespace blaze\persistence\impl;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class EntityManagerImpl extends Object implements \blaze\persistence\EntityManager{

    private $con;
    private $factory;
    private $dialect;

    private $isClosed = false;

    public function __construct(\blaze\ds\Connection $con, \blaze\persistence\EntityManagerFactory $factory, \blaze\persistence\Dialect $dialect){
        $this->con = $con;
        $this->factory = $factory;
        $this->dialect = $dialect;
    }

    public function getConnection(){
        return $this->con;
    }

    public function getEntityManagerFactory(){
        return $this->factory;
    }

    public function close() {
        $this->isClosed = true;
    }

    public function beginTransaction() {
        $this->checkClose();
        $this->con->beginTransaction();
    }

    public function commit() {
        $this->checkClose();
        $this->con->commit();
    }

    public function createQuery($queryOrStatement) {
        $this->checkClose();
        return new \blaze\persistence\query\QueryImpl($this, $this->dialect, $queryOrStatement);
    }

    public function createNativeQuery($query) {
        $this->checkClose();
    }

    public function get($class, $id) {
        $this->checkClose();
    }

    public function save(\blaze\lang\Object $object) {
        $this->checkClose();
    }

    public function saveOrUpdate(\blaze\lang\Object $object) {
        $this->checkClose();
    }

    public function update(\blaze\lang\Object $object) {
        $this->checkClose();
    }

    public function remove(\blaze\lang\Object $object) {
        $this->checkClose();
    }

    public function removeByIds($class, \blaze\collections\ListI $ids){
        $this->checkClose();
    }

    private function checkClose(){
        if($this->isClosed)
                throw new \blaze\lang\Exception('The EntityManager is already closed!');
    }
    
}

?>
