<?php

namespace blaze\ds\driver\pdomysql;

use blaze\lang\Object,
 blaze\ds\driver\pdobase\AbstractConnection,
 blaze\ds\driver\pdomysql\meta\DatabaseMetaDataImpl,
 blaze\ds\Connection,
 PDO;

/**
 * Description of ConnectionImpl
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ConnectionImpl extends AbstractConnection {

    public function __construct($driver, $host, $port, $database, $user, $password, $options) {
        parent::__construct($driver, $host, $port, $database, $user, $password, $options);
    }

    public function createStatement() {
        $this->checkClosed();
        return new StatementImpl($this, $this->pdo);
    }

    public function getMetaData() {
        $this->checkClosed();
        return new DatabaseMetaDataImpl($this, $this->pdo, $this->host, $this->port, $this->database, $this->user, $this->options);
    }

    /**
     *
     * @todo Implement
     */
    public function getTransactionIsolation() {
        $this->checkClosed();
        return null;
    }

    public function prepareCall($sql) {
        $this->checkClosed();
        return new CallableStatementImpl($this, $this->pdo, $sql);
    }

    public function prepareStatement($sql) {
        $this->checkClosed();
        return new PreparedStatementImpl($this, $this->pdo, $sql);
    }

    /**
     *
     * @Implement
     */
    public function setTransactionIsolation($level) {
        $this->checkClosed();
    }

}
?>
