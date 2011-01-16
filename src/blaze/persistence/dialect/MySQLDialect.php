<?php

namespace blaze\persistence\dialect;

use blaze\lang\Object;

/**
 * Description of Configuration
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL


 * @since   1.0


 */
class MySQLDialect extends Object implements \blaze\persistence\Dialect {

    public function getNativeQuery(\blaze\persistence\ooql\Statement $stmt, \blaze\persistence\EntityManager $em) {
        if ($stmt instanceof \blaze\persistence\ooql\FromStatement)
            return $this->fromStatement($stmt, $em);
        else if ($stmt instanceof \blaze\persistence\ooql\InsertStatement)
            return $this->insertStatement($stmt, $em);
        else if ($stmt instanceof \blaze\persistence\ooql\UpdateStatement)
            return $this->updateStatement($stmt, $em);
        else if ($stmt instanceof \blaze\persistence\ooql\DeleteStatement)
            return $this->deleteStatement($stmt, $em);
        else
            return null;
    }

    private function getSelectClause(\blaze\persistence\ooql\SelectStatement $stmt, \blaze\persistence\EntityManager $em) {

    }

    private function fromStatement(\blaze\persistence\ooql\FromStatement $stmt, \blaze\persistence\EntityManager $em) {
        $selectClauseOk = false;
        if ($stmt instanceof \blaze\persistence\ooql\SelectStatement) {
            $selectClause = $this->getSelectClause($stmt, $em);
            $selectClauseOk = true;
        } else {
            $selectClause = array();
        }

        $fromables = $stmt->getFromClause()->getFromables();
        $tables = array();
        $classes = array();

        foreach ($fromables as $fromable) {
            if ($fromable instanceof \blaze\persistence\ooql\Entity) {
                $classMeta = $em->getEntityManagerFactory()->getClassDescriptor($fromable->getName());
                $table = $classMeta->getTableDescriptor();
                $alias = $fromable->getAlias();

                if ($alias !== null)
                    $table .= ' AS ' . $alias;
                if (!$selectClauseOk)
                    $selectClause = array_merge($selectClause, $this->getTableColumns($classMeta, $alias));
                $tables[] = $table;
                $classes[$alias] = $classMeta;
            }
        }

        $condition = $stmt->getWhereClause()->getCondition();
        $where = '';
        if ($condition != null) {
            $condCount = 1;
            $where = ' WHERE ';
            if ($condition->getRight() instanceof \blaze\persistence\ooql\Condition) {
                while ($condition->getRight() instanceof \blaze\persistence\ooql\Condition) {
                    $where .= '(' . $this->getWhereColumn($condition->getLeft()->getValue(), $classes, $em) . $condition->getCondOperation();
                    $condition = $condition->getRight();
                    $condCount++;
                }
            } else {
                $where .= '(' . $this->getWhereColumn($condition->getLeft()->getValue(), $classes, $em) . $condition->getCondOperation();
            }

            $where .= $this->getWhereColumn($condition->getRight()->getValue(), $classes, $em);
            $where .= str_repeat(')', $condCount);
        }

        return 'SELECT ' . implode(',', $selectClause) . ' FROM ' . implode(' ', $tables) . $where;
    }

    private function getTableColumns(\blaze\persistence\meta\ClassDescriptor $classDesc, $alias) {
        $columns = array();

        if ($alias !== null)
            $alias .= '.';
        else
            $alias = '';

        foreach ($classDesc->getIdentifiers() as $member) {
            $columns[] = $member->getFieldDescriptor()->getColumnDescriptor();
        }
        foreach ($classDesc->getSingleFields() as $member) {
//            if($member->)
            $columns[] = $member->getColumnDescriptor();
        }
//        foreach($classDesc->getCollectionFields() as $member){
//            $columns[] = $member->getColumnDescriptor();
//        }

        return $columns;
    }

    private function recursiveColumnLookup(\blaze\persistence\meta\ClassDescriptor $classDesc, $parts) {
        $part = array_shift($parts);


        foreach ($classDesc->getIdentifiers() as $member) {
            if ($member->getFieldDescriptor()->getName()->toNative() === $part)
                return $member->getFieldDescriptor()->getColumnDescriptor();
        }
        foreach ($classDesc->getSingleFields() as $member) {
            if ($member->getName()->toNative())
                return $member->getColumnDescriptor();
        }
        foreach ($classDesc->getCollectionFields() as $member) {
            if ($member->getFieldDescriptor()->getName()->toNative())
                return $member->getColumnDescriptor();
        }

        return null;
    }

    private function getWhereColumn($string, $classMetas, \blaze\persistence\EntityManager $em) {
        $str = \blaze\lang\String::asWrapper($string);
        if ($str->startsWith(':') && !$str->contains(' '))
            return $string;
        else if ($str->equalsIgnoreCase('?'))
            return $string;
        else if ($str->startsWith('"') && $str->endsWith('"'))
            return $string;
        else if (\blaze\lang\Number::getNumberClass($string) !== null)
            return $string;
        $parts = explode('.', $string);
        $alias = null;

        foreach ($classMetas as $classAlias => $meta) {
            if ($parts[0] === $classAlias) {
                $alias = array_shift($parts);
                break;
            }
        }

        if (count($classMetas) == 1) {
            $meta = array_shift($classMetas);
            $column = $this->recursiveColumnLookup($meta, $parts);
        } else {
            foreach ($classMetas as $classAlias => $meta) {
                if ($alias === null || $alias === $classAlias)
                    $column = $this->recursiveColumnLookup($meta, $parts);
            }
        }

        if ($alias !== null)
            return $alias . '.' . $column;
        else
            return $column;
    }

    private function insertStatement(\blaze\persistence\ooql\InsertStatement $stmt, \blaze\persistence\EntityManagerFactory $fact) {

    }

    private function updateStatement(\blaze\persistence\ooql\UpdateStatement $stmt, \blaze\persistence\EntityManagerFactory $fact) {

    }

    private function deleteStatement(\blaze\persistence\ooql\DeleteStatement $stmt, \blaze\persistence\EntityManagerFactory $fact) {
        
    }

}

?>
