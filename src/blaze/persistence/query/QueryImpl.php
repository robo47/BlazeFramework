<?php

namespace blaze\persistence\query;

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
class QueryImpl extends Object implements \blaze\persistence\Query {

    private $session;
    private $query;
    private $stmt;
    private $timeout = 0;
    private $type;

    public function __construct(\blaze\persistence\Session $session, $query) {
        $this->session = $session;
        $this->query = $query;
        $con = $this->session->getConnection();
        
        if($query instanceof \blaze\persistence\ooql\Statement)
            $this->stmt = $con->prepareStatement();
        else
            $this->stmt = $con->prepareStatement();
    }

    public function getList() {
        
    }

    public function getUniqueResult() {
        
    }

    public function executeUpdate() {

    }

    public function getQueryString() {
        return $this->query;
    }

    public function getTimeout() {
        return $this->timeout;
    }

    public function getType() {
        return $this->type;
    }

    public function setTimeout($seconds) {
        $this->timeout = $seconds;
    }

    public function setBlob($identifier, \blaze\ds\type\Blob $value) {
        $this->stmt->setBlob($identifier, $value);
    }

    public function setBoolean($identifier, $value) {
        $this->stmt->setBoolean($identifier, $value);
    }

    public function setByte($identifier, $value) {
        $this->stmt->setByte($identifier, $value);
    }

    public function setClob($identifier, \blaze\ds\type\Clob $value) {
        $this->stmt->setClob($identifier, $value);
    }

    public function setDate($identifier, \blaze\util\Date $value) {
        $this->stmt->setDate($identifier, $value);
    }

    public function setDecimal($identifier, \blaze\math\BigDecimal $value) {
        $this->stmt->setDecimal($identifier, $value);
    }

    public function setDouble($identifier, $value) {
        $this->stmt->setDouble($identifier, $value);
    }

    public function setEntity($identifier, \blaze\lang\Object $value) {
//        $meta = $this->session->getSessionFactory()->getClassMeta($value);
//
//        if($meta === null)
//            throw new PersistenceException('Class of the given object is not registered in the session factory.');
//
//        $joinMembers = array();
//
//        foreach($meta->getMembers() as $member){
//            if($member instanceof \blaze\persistence\tool\metainfo\IdMetaInfo)
//                $joinMembers[] = $member;
//        }
//
//        foreach($joinMembers as $member){
//
//        }
    }

    public function setFloat($identifier, $value) {
        $this->stmt->setFloat($identifier, $value);
    }

    public function setInt($identifier, $value) {
        $this->stmt->setInt($identifier, $value);
    }

    public function setLong($identifier, $value) {
        $this->stmt->setLong($identifier, $value);
    }

    public function setNClob($identifier, \blaze\ds\type\NClob $value) {
        $this->stmt->setNClob($identifier, $value);
    }

    public function setNString($identifier, $value) {
        $this->stmt->setNString($identifier, $value);
    }

    public function setNull($identifier) {
        $this->stmt->setNull($identifier);
    }

    public function setString($identifier, $value) {
        $this->stmt->setString($identifier, $value);
    }

    public function setTime($identifier, \blaze\util\Date $value) {
        $this->stmt->setTime($identifier, $value);
    }

    public function setTimestamp($identifier, \blaze\util\Date $value) {
        $this->stmt->setTimestamp($identifier, $value);
    }

}

?>
