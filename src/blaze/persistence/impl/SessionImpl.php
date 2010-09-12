<?php
namespace blaze\persistence\impl;
use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class SessionImpl extends Object implements \blaze\persistence\Session{

    private $con;
    private $factory;

    private $isClosed = false;

    public function __construct(\blaze\ds\Connection $con, \blaze\persistence\SessionFactory $factory){
        $this->con = $con;
        $this->factory = $factory;
    }

    public function getConnection(){
        return $this->con;
    }

    public function getSessionFactory(){
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

    public function createCriteria($class) {
        $this->checkClose();
    }

    public function createQuery($query) {
        $this->checkClose();
        return new \blaze\persistence\query\QueryImpl($this, $query);
    }

    public function createSqlQuery($query) {
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

    public function removeByIds($class, blaze\collections\ListI $ids){
        $this->checkClose();
    }

    private function checkClose(){
        if($this->isClosed)
                throw new \blaze\lang\Exception('The session is already closed!');
    }
    
}

?>
