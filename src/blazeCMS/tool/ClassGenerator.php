<?php
namespace blazeCMS\tool;
use blaze\lang\Object,
blaze\lang\String,
blaze\io\File;

/**
 * Description of ClassGenerator
 *
 * @author  RedShadow
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class ClassGenerator extends Object {

    /**
     *
     * @var \PDO
     */
    private $con;
    /**
     *
     * @var blaze\io\File
     */
    private $saveDir;
    /**
     *
     * @var \PDOStatement
     */
    private $memberStmt;
    /**
     *
     * @var \PDOStatement
     */
    private $inverseStmt;
    /**
     *
     * @var \PDOStatement
     */
    private $columnStmt;

    public function __construct() {
        $this->con = \blazeCMS\dao\GenericDAO::getInstance()->getConnection();
        $sql  = 'SELECT * FROM information_schema.KEY_COLUMN_USAGE, information_schema.REFERENTIAL_CONSTRAINTS WHERE ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.TABLE_SCHEMA = ? AND ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.TABLE_NAME = ? AND ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.COLUMN_NAME = ? AND ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.CONSTRAINT_NAME IN(information_schema.REFERENTIAL_CONSTRAINTS.CONSTRAINT_NAME)';
        $this->memberStmt = $this->con->prepare($sql);

        $sql  = 'SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.REFERENCED_TABLE_SCHEMA = ? AND ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.REFERENCED_TABLE_NAME = ? AND ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.REFERENCED_COLUMN_NAME = ?';
        $this->inverseStmt = $this->con->prepare($sql);

        $sql  = 'SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.TABLE_SCHEMA = ? AND ';
        $sql .= 'information_schema.KEY_COLUMN_USAGE.TABLE_NAME = ?';
        $this->columnStmt = $this->con->prepare($sql);
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blaze\lang\Object Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
    public function generateForDb($targetDir, $package = 'blazeCMS\\model') {
        $stmt = $this->con->query('SHOW TABLES');
        $this->saveDir = new File($targetDir,$package);

        while(($row = $stmt->fetch(\PDO::FETCH_NUM)) !== false) {
            $this->generateClass($this->getTable($row[0]), $targetDir, $package);
        }
    }

    /**
     * @param string $tableName
     * @return DbTable
     */
    private function getTable($tableName) {
        $escapeChar = '`';
        $this->columnStmt->bindValue(1, 'mydb', \PDO::PARAM_STR);
        $this->columnStmt->bindValue(2, $tableName, \PDO::PARAM_STR);
        //$this->columnStmt->bindValue(3, '%', \PDO::PARAM_STR);
        $this->columnStmt->execute();

        $table = new DbTable();
        $table->setTableName($tableName);
        $table->setSchema('mydb');

        while(($row = $this->columnStmt->fetch(\PDO::FETCH_ASSOC)) !== false) {
            var_dump($row);
            $column = new DbColumn();
            $column->setName($row['Field']);
            $type = explode('(',$row['Type']);
            $column->setType($type[0]);

            if(count($type) > 1) {
                $typeLen = explode(',',substr($type[1], 0, strlen($type[1]) - 1));
                if(count($typeLen) < 2)
                    $column->setLength($typLen[0]);
                else {
                    $column->setScale($typLen[0]);
                    $column->setPrecision($typLen[1]);
                }
            }

            $column->setNullable($row['Null'] == 'YES');
            $column->setPrimaryKey($row['Key'] == 'PRI');
            $column->setForeignKey($row['Key'] == 'MUL');
            $column->setUniqueKey($row['Key'] == 'UNI');
            $table->add($column);
        }

        return $table;
    }

    private function generateClass(DbTable $table, $targetDir, $package) {
        $className = $this->toCamelCase($table->getTableName());
        $classMembers = $this->getClassMembers($table, $package);

        if(count($classMembers) > 0){
            $str = '<?php'.
                    '\nnamespace '.$package.';'.
                    '\nuse blaze\lang\Object;'.
                    '\n'.
                    '\nclass '.$className.' extends Object {';
            foreach($classMembers as $column)
                $str .= $this->getVariable($column);
            foreach($classMembers as $column)
                $str .= $this->getGetterAndSetter($column, $className, $package);

            $str .='\n}'.
                    '\n?>';
            $f = new File($this->saveDir,$className.'.php');
            $fp = fopen($f->getAbsolutePath(),'w');
            fwrite($fp, str_replace('\n', "\n", $str));
            fclose($fp);
        }
    }

    private function getGetterAndSetter(ClassMember $member, $className, $package) {
        $memberNameBig = String::asWrapper($member->getName())->toUpperCase(true)->toNative();
        $memberName = $member->getName()->toNative();
        $memberType = $member->getType();

        return '\n    /**'.
                '\n     * @return '.$memberType.
                '\n     */'.
                '\n    public function get'.$memberNameBig.'(){'.
                '\n       return $this->'.$memberName.';'.
                '\n    }'.
                '\n    /**'.
                '\n     * @param '.$memberType.' $'.$memberName.
                '\n     * @return '.$package.'\\'.$className.
                '\n     */'.
                '\n    public function set'.$memberNameBig.'($'.$memberName.'){'.
                '\n       $this->'.$memberName.' = $'.$memberName.';'.
                '\n       return $this;'.
                '\n    }';

    }

    private function getVariable(ClassMember $member) {
        return '\n    /**'.
               '\n     * @var '.$member->getType().
               '\n     */'.
               '\n    private $'.$member->getName()->toNative().';'.
               '\n    ';

    }

    private function toCamelCase($value) {
        $str = '';
        $parts = explode('_',$value);

        foreach($parts as $part) {
            $str .= ucfirst($part);
        }

        return new String($str);
    }

    private function getDataType(DbColumn $column) {
        switch(String::asWrapper($column->getType())->toLowerCase()->toNative()) {
            case 'int':
                return 'integer';
                break;
            case 'tinyint':
                return 'boolean';
                break;
            case 'char':
                return 'string';
                break;
            case 'varchar':
                return 'integer';
                break;
            case 'numeric':
                return 'integer';
                break;
            case 'decimal':
                return 'integer';
                break;
            case 'date':
                return 'string';
                break;
            default:
                return 'string';
                break;
        }
    }

    private function getClassMembers(DbTable $table, $package){
        $members = array();
        $inverse = array();
        $columns = $table->getColumns();

        if(count($columns) == 2 && $columns[0]->getForeignKey() && $columns[1]->getForeignKey())
                return $members;
        if(count($columns) == 2)
            var_dump($columns[0]);
        foreach($columns as $column){
            if($column->getForeignKey())
                //relation
                $members[] = $this->getMember($table, $column, $package);
            else
                //Standard column
                $members[] = new ClassMember($this->toCamelCase($column->getName())->toLowerCase(true),
                                             $this->getDataType($column), $column);
            $inverse = array_merge($inverse, $this->getInverseMembers($table, $column, $package));
        }
        //var_dump(array_merge($members, $inverse));
        return array_merge($members, $inverse);
    }

    /**
     *
     * @param DbTable $table
     * @param DbColumn $column
     * @param string $package
     * @return blazeCMS\tool\ClassMember
     */
    private function getMember(DbTable $table, DbColumn $column, $package) {
        $this->memberStmt->bindValue(1, 'mydb', \PDO::PARAM_STR);
        $this->memberStmt->bindValue(2, $table->getTableName(), \PDO::PARAM_STR);
        $this->memberStmt->bindValue(3, $column->getName(), \PDO::PARAM_STR);
        $this->memberStmt->execute();

        $row = $this->memberStmt->fetch(\PDO::FETCH_ASSOC);
        $className = $this->toCamelCase($row['REFERENCED_TABLE_NAME']);
        return new ClassMember($className->toLowerCase(true), $package.'\\'.$className->toNative(), $column);
    }

    /**
     *
     * @param DbTable $table
     * @param DbColumn $column
     * @param string $package
     * @return array[blazeCMS\tool\ClassMember]
     */
    private function getInverseMembers(DbTable $table, DbColumn $column, $package) {
        $this->inverseStmt->bindValue(1, 'mydb', \PDO::PARAM_STR);
        $this->inverseStmt->bindValue(2, $table->getTableName(), \PDO::PARAM_STR);
        $this->inverseStmt->bindValue(3, $column->getName(), \PDO::PARAM_STR);
        $this->inverseStmt->execute();
        
        $keys = array();

        while(($row = $this->inverseStmt->fetch(\PDO::FETCH_ASSOC)) != false){
            $tbl = $this->getTable($row['TABLE_NAME']);
            $cols = $tbl->getColumns();

            if(count($cols) == 2){
                //n:m-relation
                if($cols[0]->getName() != $row['COLUMN_NAME'])
                    $col = $cols[0];
                else
                    $col = $cols[1];

                $listMember = $this->getMember($tbl, $col, $package);
                $keys[] = new ClassMember($listMember->getName().'s', 'blaze\util\ListI', $column);
                //var_dump($this->getMember($tbl, $col, $package));
            }else{
                //1:n-relation
                $className = $this->toCamelCase($row['TABLE_NAME']);
                $keys[] = new ClassMember($className->toLowerCase(true).'s', 'blaze\util\ListI', $column);//['.$package.'\\'.$className.']');
            }
        }
        return $keys;
    }
}

?>
