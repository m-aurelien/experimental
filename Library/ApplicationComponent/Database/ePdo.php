<?php
/**
 * Created by Aurelien
 * Date: 30/07/13
 * Time: 15:02
 */

namespace Library\ApplicationComponent\Database;


class ePdo extends \PDO {
    public function __construct($dsn, $username = '', $passwd = '', $options = array()){
        parent::__construct($dsn, $username, $passwd, $options);
        $this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
        $this->setAttribute(self::ATTR_STATEMENT_CLASS, array('Library\ApplicationComponent\Database\eStatement'));
    }

    /**
     * @param string $statement
     * @param array $driver_options
     * @return \Library\ApplicationComponent\Database\eStatement|void
     */
    public function prepare($statement, $driver_options = array())
    {
        return parent::prepare($statement, $driver_options);
    }

    public function listTable(){
        $sql = 'SHOW TABLES';
        $statement = $this->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_NUM);
    }

    public function describeTable($table_name)
    {
        $sql = sprintf('DESCRIBE %s', $table_name);
        $statment = $this->prepare($sql);

        $statment->execute();

        return $statment->fetchAll(\PDO::FETCH_OBJ);
    }

}