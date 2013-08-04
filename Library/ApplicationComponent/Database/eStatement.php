<?php
/**
 * Created by Aurelien
 * Date: 29/07/13
 * Time: 12:23
 */

namespace Library\ApplicationComponent\Database;


final class eStatement extends \PDOStatement {
    /**
     * Internal stuff to check for class validity
     *
     * @param $className
     * @throws \PDOException
     */
    private function _prepareFetchObject($className, $nameSpace){
        $class = ($nameSpace) ? $nameSpace.$className : $className;
        if (!class_exists($class)){
            throw new \PDOException('Class '.$class.' does not exist');
        }

        return $class;
    }

    /**
     * Fetch a result as an object of a class specified
     *
     * @param $className
     * @param string $nameSpace
     * @return mixed
     */
    public function fetchObjectOfClass($className, $nameSpace = "\\Applications\\OneTry\\Models\\ORM\\"){
        $class = $this->_prepareFetchObject($className, $nameSpace);

        $this->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, $class);

        return parent::fetch();
    }

    /**
     * Fetch all results as objects of a class specified
     *
     * @param $className
     * @param string $nameSpace
     * @return array
     */
    public function fetchAllObjectOfClass($className, $nameSpace = "\\Applications\\OneTry\\Models\\ORM\\"){
        $class = $this->_prepareFetchObject($className, $nameSpace);

        return parent::fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, $class);
    }
}