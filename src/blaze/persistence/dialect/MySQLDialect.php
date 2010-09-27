<?php
namespace blaze\persistence\dialect;
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
class MySQLDialect extends Object implements \blaze\persistence\Dialect{

    public function getNativeQuery(\blaze\persistence\ooql\Statement $stmt, \blaze\persistence\SessionFactory $fact) {
        if($stmt instanceof \blaze\persistence\ooql\FromStatement)
            return $this->fromStatement($stmt, $fact);
        else if($stmt instanceof \blaze\persistence\ooql\InsertStatement)
            return $this->insertStatement($stmt, $fact);
        else if($stmt instanceof \blaze\persistence\ooql\UpdateStatement)
            return $this->updateStatement($stmt, $fact);
        else if($stmt instanceof \blaze\persistence\ooql\DeleteStatement)
            return $this->deleteStatement($stmt, $fact);
        else
            return null;
    }

    private function getSelectClause(\blaze\persistence\ooql\SelectStatement $stmt, \blaze\persistence\SessionFactory $fact){

    }

    private function fromStatement(\blaze\persistence\ooql\FromStatement $stmt, \blaze\persistence\SessionFactory $fact){
        $selectClauseOk = false;
        if($stmt instanceof \blaze\persistence\ooql\SelectStatement){
            $selectClause = $this->getSelectClause($stmt, $fact);
            $selectClauseOk = true;
        }else{
            $selectClause = array();
        }

        $fromables = $stmt->getFromClause()->getFromables();
        $tables = array();
        $classes = array();

        foreach($fromables as $fromable){
            if($fromable instanceof \blaze\persistence\ooql\Entity){
                $classMeta = $fact->getClassMetaByString($fromable->getName());
                $table = $classMeta->getTable();
                $alias = $fromable->getAlias();

                if($alias !== null)
                    $table .= ' AS '.$alias;
                if(!$selectClauseOk)
                    $selectClause = array_merge($selectClause, $this->getTableColumns($classMeta, $alias));
                $tables[] = $table;
                $classes[$alias] = $classMeta;
            }
        }

        $condition = $stmt->getWhereClause()->getCondition();
        $where = '';
        if($condition != null){
            $condCount = 1;

            if($condition->getRight() instanceof \blaze\persistence\ooql\Condition){
                while($condition->getRight() instanceof \blaze\persistence\ooql\Condition){
                    $where .= '('.$this->getWhereColumn($condition->getLeft()->getValue(),$classes,$fact).$condition->getCondOperation();
                    $condition = $condition->getRight();
                    $condCount++;
                }
            }else{
                $where .= '('.$this->getWhereColumn($condition->getLeft()->getValue(),$classes,$fact).$condition->getCondOperation();
            }

            $where .= $this->getWhereColumn($condition->getRight()->getValue(),$classes,$fact);
            $where .= str_repeat(')', $condCount);
        }

        return 'SELECT '.implode(',', $selectClause).' FROM '.implode(' ', $tables).' WHERE '.$where;
    }

    private function getTableColumns(\blaze\persistence\tool\metainfo\ClassMetaInfo $classMeta, $alias) {
        $columns = array();

        if($alias !== null)
            $alias .= '.';
        else
            $alias = '';

        foreach($classMeta->getMembers() as $member){
            if($member instanceof \blaze\persistence\tool\metainfo\SetMetaInfo)
                ;//$columns[] = $alias.$member->getKey()->getColumn()->getName();
            else if($member instanceof \blaze\persistence\tool\metainfo\PropertyMetaInfo)
                $columns[] = $alias.$member->getColumn()->getName();
            else if($member instanceof \blaze\persistence\tool\metainfo\ManyToOneMetaInfo)
                $columns[] = $alias.$member->getColumn()->getName();
        }

        return $columns;
    }

    private function recursiveColumnLookup(\blaze\persistence\tool\metainfo\ClassMetaInfo $classMeta, $parts){
        $part = array_shift($parts);

        foreach($classMeta->getMembers() as $member){
            if($member instanceof \blaze\persistence\tool\metainfo\SetMetaInfo && $member->getName() === $part){
                return $member->getKey()->getColumn()->getName();
            }else if($member instanceof \blaze\persistence\tool\metainfo\PropertyMetaInfo && $member->getName() === $part){
                return $member->getColumn()->getName();
            }else if($member instanceof \blaze\persistence\tool\metainfo\ManyToOneMetaInfo && $member->getName() === $part){
                return $member->getColumn()->getName();
            }
        }
    }

    private function getWhereColumn($string, $classMetas, \blaze\persistence\SessionFactory $fact){
        $str = \blaze\lang\String::asWrapper($string);
        if($str->startsWith(':') && !$str->contains(' '))
                return $string;
        else if($str->equalsIgnoreCase('?'))
                return $string;
        else if($str->startsWith('"') && $str->endsWith('"'))
            return $string;
        else if(\blaze\lang\Number::getNumberClass($string) !== null)
            return $string;
        $parts = explode('.',$string);
        $alias = null;

        foreach($classMetas as $alias => $meta){
            if($parts[0] === $alias){
                $alias = array_shift($parts);
                break;
            }
        }

        if(count($classMetas) == 1){
            $meta = array_shift($classMetas);
            $column = $this->recursiveColumnLookup($meta, $parts);
        }else{
            foreach($classMetas as $classAlias => $meta){
                if($alias === null || $alias === $classAlias)
                    $column = $this->recursiveColumnLookup($meta, $parts);
            }
        }

        if($alias !== null)
            return $alias.'.'.$column;
        else
            return $column;
    }

    private function insertStatement(\blaze\persistence\ooql\InsertStatement $stmt, \blaze\persistence\SessionFactory $fact){

    }

    private function updateStatement(\blaze\persistence\ooql\UpdateStatement $stmt, \blaze\persistence\SessionFactory $fact){

    }

    private function deleteStatement(\blaze\persistence\ooql\DeleteStatement $stmt, \blaze\persistence\SessionFactory $fact){

    }
}

?>
