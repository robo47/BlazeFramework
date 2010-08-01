<?php
namespace blaze\ds\driver\pdomysql\meta;
use blaze\lang\Object,
    blaze\ds\driver\pdobase\meta\AbstractConstraintMetaData;

/**
 * Description of AbstractConstraintMetaData
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Classes which could be useful for the understanding of this class. e.g. ClassName::methodName
 * @since   1.0
 * @version $Revision$
 * @todo    Something which has to be done, implementation or so
 */
class ConstraintMetaDataImpl extends AbstractConstraintMetaData {

    /**
     *
     * @param array[\blaze\ds\meta\ColumnMetaData] $column
     * @param blaze\lang\String $constraintName
     * @param blaze\lang\String $constraintType
     */
    public function __construct($columns, $constraintName, $constraintType){
        $this->columns = $columns;
        $this->constraintName = $constraintName;
        $this->constraintType = $constraintType;
    }

    private function getCols(\blaze\ds\meta\ColumnMetaData $column){
        $stmt = null;
        $rs = null;
        $constType = null;
        $constraint = null;

        try{
            $con = $column->getTable()->getSchema()->getDatabaseMetaData()->getConnection();
            $stmt = $con->prepareStatement('SELECT * FROM information_schema.TABLE_CONSTRAINTS JOIN information_schema.KEY_COLUMN_USAGE ON KEY_COLUMN_USAGE.TABLE_SCHEMA = TABLE_CONSTRAINTS.TABLE_SCHEMA AND KEY_COLUMN_USAGE.TABLE_NAME = TABLE_CONSTRAINTS.TABLE_NAME AND KEY_COLUMN_USAGE.CONSTRAINT_NAME = TABLE_CONSTRAINTS.CONSTRAINT_NAME WHERE KEY_COLUMN_USAGE.TABLE_SCHEMA = ? AND KEY_COLUMN_USAGE.TABLE_NAME = ? AND KEY_COLUMN_USAGE.CONSTRAINT_NAME = ?');
            $stmt->setString(0, $column->getTable()->getSchema()->getSchemaName());
            $stmt->setString(1, $column->getTable()->getTableName());
            $stmt->setString(2, $constraintName);
            $stmt->execute();

//            $rs = $stmt->getResultSet();
//            $rsmd = $stmt->getMetaData();
//
//            while($rs->next())
//                    $tblConst[$rs->getString('CONSTRAINT_NAME')->__toString()] = $rs->getString('CONSTRAINT_TYPE');
//
//            if($stmt != null)
//                $stmt->close();
//            if($rs != null)
//                $rs->close();
//
//            $stmt = $this->table->getSchema()->getDatabaseMetaData()->getConnection()->prepareStatement('SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?');
//            $stmt->setString(0, $this->table->getSchema()->getSchemaName());
//            $stmt->setString(1, $this->table->getTableName());
//            $stmt->setString(2, $this->columnName);
//            $stmt->execute();
//            $rs = $stmt->getResultSet();
//
//            while($rs->next()){
//                switch($tblConst[$rs->getString('CONSTRAINT_NAME')->__toString()]){
//                    case 'PRIMARY KEY':
//                        $constraint = new ConstraintMetaDataImpl($this, $rs->getString('CONSTRAINT_NAME'), 'PRIMARY KEY');
//                        break;
//                    case 'FOREIGN KEY':
//                        $refSch = $this->table
//                                       ->getSchema()
//                                       ->getDatabaseMetaData()
//                                       ->getSchema($rs->getString('REFERENCED_TABLE_SCHEMA'));
//
//                        if($refSch == null)
//                            break;
//
//                        $refCol = $refSch->getTable($rs->getString('REFERENCED_TABLE_NAME'))
//                                       ->getColumn($rs->getString('REFERENCED_COLUMN_NAME'));
//                        $constraint = new ForeignKeyMetaDataImpl($this, $refCol, $rs->getString('CONSTRAINT_NAME'));
//                        break;
//                    case 'UNIQUE':
//                        $constraint = new ConstraintMetaDataImpl($this, $rs->getString('CONSTRAINT_NAME'), 'UNIQUE KEY');
//                        break;
//                    default:
//                        $constraint = new ConstraintMetaDataImpl($this, $rs->getString('CONSTRAINT_NAME'), 'UNKNOWN');
//                        break;
//                }
//            }
        }catch(\blaze\ds\SQLException $e){throw $e;}

        if($stmt != null)
            $stmt->close();
        if($rs != null)
            $rs->close();
    }

}

?>
