<?php

namespace blaze\ds\driver\pdobase;

use blaze\lang\Object,
 blaze\ds\Connection,
 blaze\ds\Statement,
 PDO;

/**
 * Description of AbstractStatement
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
abstract class AbstractStatement extends AbstractStatement1 implements Statement {

    public function execute($sql) {
        $this->checkclosed();

        try {
            $this->reset();
            $this->stmt = $this->pdo->query($sql);

            if ($this->stmt instanceof \PDOStatement)
                return true;

            $this->stmt = null;
            return false;
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }
    }

    public function executeUpdate($sql) {
        $this->checkclosed();

        $result = 0;

        try {
            $this->reset();
            $result = $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new DataSourceException($e->getMessage(), $e->getCode());
        }

        return $result;
    }

}
?>
