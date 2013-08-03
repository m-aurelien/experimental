<?php
/**
 * Created by Aurelien
 * Date: 01/07/13
 * Time: 23:24
 */

namespace Library\ApplicationComponent\Database;


use Library\ApplicationComponent\ApplicationComponent;

class PDOFactory extends ApplicationComponent
{
    private $mySqlConnection = null;

    public function mysql(){
        if($this->mySqlConnection == null){
            $this->mySqlConnection = new ePdo('mysql:host='.$this->config()->get('mysql_host').';dbname='.$this->config()->get('mysql_db_name'),
                                               $this->config()->get('mysql_login'),
                                               $this->config()->get('mysql_password'));
        }

        return $this->mySqlConnection;
    }
}