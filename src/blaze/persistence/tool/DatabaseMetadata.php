<?php
namespace blaze\persistence\tool;
use blaze\lang\Object,
    blaze\ds\Connection;

/**
 * Description of DatabaseMetadata
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class DatabaseMetadata extends Object {

    private $con;

    public function __construct(Connection $con){
        $this->con = $con;
    }

    public function getTableMetadata($tableName, $schema){
        
    }
}

?>
