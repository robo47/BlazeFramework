<?php
namespace blaze\sql\driver\pdobase;
use blaze\lang\Object,
blaze\sql\DatabaseMetaData ;

/**
 * Description of AbstractDatabaseMetaData
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
abstract class AbstractDatabaseMetaData extends Object implements DatabaseMetaData {

    private $con;
    private $dsn;
    private $user;
    
    protected function __construct(Connection $con, $dsn, $user) {
        $this->con = $con;
        $this->dsn = $dsn;
        $this->user = $user;
    }

    public function getColumns($table, $schema = null) {
    }
    public function getDatabaseProductName() {
    }
    public function getDatabaseProductVersion() {
    }
    public function getDriverName() {
    }
    public function getDriverVersion() {
    }
    public function getPrimaryKeys($table, $schema = null) {
    }
    public function getTables($schema) {
    }
    public function getURL() {
        return $this->dsn;
    }
    public function getUser() {
        return $this->user;
    }
}

?>
