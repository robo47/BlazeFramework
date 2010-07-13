<?php
namespace blaze\sql\driver\pdobase;
use blaze\lang\Object,
blaze\sql\Connection,
blaze\sql\Statement,
PDO;

/**
 * Description of AbstractStatement
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractStatement extends AbstractStatement1 implements Statement {

    public function execute($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = $this->pdo->query($sql);
    }
    public function executeQuery($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = $this->pdo->query($sql);
    }
    public function executeUpdate($sql) {
        if($this->isClosed())
            throw new SQLException('Statement is already closed.');
        if($this->stmt != null)
                $this->stmt->closeCursor();
        $this->stmt = $this->pdo->exec($sql);
    }

}

?>
