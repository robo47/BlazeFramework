<?php
namespace blazeCMS\dao;
use blaze\lang\Object;
use blaze\lang\Singleton;
use blaze\ds\SQLException;

/**
 * Description of GenericDAO
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class GenericDAO extends Object implements Singleton{

    /**
     *
     * @var GenericDAO
     */
    private static $instance;
    /**
     *
     * @var PDO
     */
    private $connection;
    /**
     *
     * @var string
     */
    private $dsn = 'mysql:dbname=mydb;host=localhost';
    /**
     *
     * @var string
     */
    private $user = 'root';
    /**
     *
     * @var string
     */
    private $password = '';

    /**
     *
     * @var array
     */
    private $options = array( \PDO::ATTR_PERSISTENT => true,
                              \PDO::ATTR_AUTOCOMMIT => false,
                              \PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION);

    /**
     * Beschreibung
     */
    private function __construct(){
        $this->connection = new \PDO($this->dsn, $this->user, $this->password, $this->options);
    }

    /**
     * Beschreibung
     *
     * @param 	blaze\lang\Object $var Beschreibung des Parameters
     * @return 	blazeCMS\dao\GenericDAO Beschreibung was die Methode zurückliefert
     * @see 	Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
     * @throws	blaze\lang\Exception
     * @todo	Etwas was noch erledigt werden muss
     */
     public static function getInstance(){
        if(self::$instance == null)
            self::$instance = new GenericDAO();
        return self::$instance;
     }

     /**
      *
      * @return PDO
      */
     public function getConnection(){
         return $this->connection;
     }

     /**
      *
      * @param Table $table
      * @param GenericTableEntry $entry
      * @return integer The id of the inserted entry
      */
     public function add(Table $table, GenericTableEntry $entry){
         $columns = $table->getColumns();
         $columnCount = count($columns);
         $columnPlaceHolder = ':col0';
         $i = 1;

         do{
             $columnPlaceHolder .= ',:col'.$i;
         }while($i++ < $columnCount);

        $sql = 'INSERT INTO :table(:columns) VALUES('.$columnPlaceHolder.')';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':columns',$table->getColumnsAsString(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);

        for($i = 0; $i < $columnCount; $i++){
            $column = $columns[$i];
            $stmt->bindValue(':col'.$i,$entry->getValue($column->getName()), $column->getType());
        }

        if($stmt->execute())
            return $this->connection->lastInsertId();

        throw new SQLException('Could not add the entry into the table '.$table->getTableName());
     }

     /**
      *
      * @param Table $table
      * @param array $ids
      * @param string $where
      * @return integer The number of affected rows
      */
     public function delete(Table $table, $ids, $where = null){
        $sql = 'DELETE FROM :table';

         if($where != null)
             $sql .= ' WHERE :idName IN(:ids) AND :where';
         else
             $sql .= ' WHERE :idName IN(:ids)';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id',$table->getId()->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);
        $stmt->bindValue(':ids',implode(',',$ids), \PDO::PARAM_STR);

        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt->rowCount();
        throw new SQLException('Could not delete the entry from the table '.$table->getTableName());
     }

     /**
      *
      * @param Table $table
      * @param GenericTableEntry $entry
      * @param string $where
      * @return integer
      */
     public function update(Table $table, GenericTableEntry $entry, $where = null){
         $columns = $table->getColumns();
         $columnCount = count($columns);
         $columnPlaceHolder = ':col0 = :colVal0';
         $i = 1;

         do{
             $columnPlaceHolder .= ',:col'.$i.' = colVal'.$i;
         }while($i++ < $columnCount);

        $sql = 'UPDATE :table SET :columnAssign';

         if($where != null)
             $sql .= ' WHERE :idName = :id AND :where';
         else
             $sql .= ' WHERE :idName = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':columnAssign',$table->getColumnsAsString(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);
        $stmt->bindValue(':idName',$table->getId()->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':id',$entry->getValue($table->getId()->getName()), $table->getId()->getType());

        for($i = 0; $i < $columnCount; $i++){
            $column = $columns[$i];
            $stmt->bindValue(':col'.$i,$column->getName(), \PDO::PARAM_STR);
            $stmt->bindValue(':colVal'.$i,$entry->getValue($column->getName()), $column->getType());
        }

        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt->rowCount();

        throw new SQLException('Could not update the entry into the table '.$table->getTableName());
     }

     /**
      *
      * @param Table $table
      * @param string $where
      * @return int
      */
     public function getCount(Table $table, $where = null){
         $sql = 'SELECT COUNT(*) FROM :table';

         if($where != null)
             $sql .= ' WHERE :where';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);
        
        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        throw new SQLException('Statement could not be executed.');
     }

     /**
      *
      * @param Table $table
      * @param string $where
      * @return array
      */
     public function getIds(Table $table, $where = null){
         $sql = 'SELECT :id FROM :table';

         if($where != null)
             $sql .= ' WHERE :where';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id',$table->getId()->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);

        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt->fetchAll(\PDO::FETCH_NUM);
        throw new SQLException('Statement could not be executed.');
     }

     /**
      *
      * @param Table $table
      * @param array $ids
      * @param string $index
      * @param string $where
      * @return array[GenericTableEntry]
      */
     public function getByIds(Table $table, $ids, $index = null, $where = null){
         $sql = 'SELECT :columns FROM :table';

         if($where != null)
             $sql .= ' WHERE :idName IN(:ids) AND :where';
         else
             $sql .= ' WHERE :idName IN(:ids)';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':columns',$table->getColumnsAsString(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);
        $stmt->bindValue(':idname',$table->getId()->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':ids',implode(',',$ids), \PDO::PARAM_STR);

        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute()){
            $all = array();

            while(($row = $stmt->fetch(\PDO::FETCH_ASSOC)) != false){
                    $entry = new GenericTableEntry($this->table);
                    if($index == null)
                        $all[] = $entry->setValues($row);
                    else
                        $all[$row[$index]] = $entry->setValues($row);
            }

            return $all;
        }
        
        throw new SQLException('Statement could not be executed.');
     }

     /**
      *
      * @param Table $table
      * @param string $index
      * @param string $where
      * @return array[GenericTableEntry]
      */
     public function getAll(Table $table, $index = null, $where = null){
         $sql = 'SELECT :columns FROM :table';

         if($where != null)
             $sql .= ' WHERE :where';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':columns',$table->getColumnsAsString(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);

        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute()){
            $all = array();

            while(($row = $stmt->fetch(\PDO::FETCH_ASSOC)) != false){
                    $entry = new GenericTableEntry($this->table);
                    if($index == null)
                        $all[] = $entry->setValues($row);
                    else
                        $all[$row[$index]] = $entry->setValues($row);
            }

            return $all;
        }

        throw new SQLException('Statement could not be executed.');
     }

     /**
      *
      * @param Table $table
      * @param array $ids
      * @param string $where
      * @return boolean
      */
     public function existsIds(Table $table, $ids, $where = null) {
         $sql = 'SELECT COUNT(*) FROM :table';

         if($where != null)
             $sql .= ' WHERE :idName IN(:ids) AND :where';
         else
             $sql .= ' WHERE :idName IN(:ids)';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':columns',$table->getColumnsAsString(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);
        $stmt->bindValue(':idname',$table->getId()->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':ids',implode(',',$ids), \PDO::PARAM_STR);

        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt->fetch(\PDO::FETCH_COLUMN) != 0;

        throw new SQLException('Statement could not be executed.');
    }

    /**
      *
      * @param Table $table
      * @param mixed $id
      * @param string $where
      * @return boolean
      */
     public function existsId(Table $table, $id, $where = null) {
         $sql = 'SELECT COUNT(*) FROM :table';

         if($where != null)
             $sql .= ' WHERE :idName = :id AND :where';
         else
             $sql .= ' WHERE :idName = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':columns',$table->getColumnsAsString(), \PDO::PARAM_STR);
        $stmt->bindValue(':table',$table->getTableName(), \PDO::PARAM_STR);
        $stmt->bindValue(':idname',$table->getId()->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(':id',$id, \PDO::PARAM_STR);

        if($where != null)
            $stmt->bindValue(':where',$where, \PDO::PARAM_STR);

        if($stmt->execute())
            return $stmt->fetch(\PDO::FETCH_COLUMN) != 0;

        throw new SQLException('Statement could not be executed.');
    }
}

?>
