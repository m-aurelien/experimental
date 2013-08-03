<?php
/**
 * Created by Aurelien
 * Date: 01/08/13
 * Time: 09:46
 */

namespace Library\ApplicationComponent\Database;


class eUser implements DaoInterface {
    const ID = "id";
    const LASTNAME = "lastname";
    const FIRSTNAME = "firstname";
    const USERNAME = "username";
    const PASSWORD = "password";

    private $id;
    private $lastname;
    private $firstname;
    private $username;
    private $password;

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


    public function toString()
    {
        // TODO: Implement toString() method.
    }

    public static function doSelect($sql)
    {
        // TODO: Implement doSelect() method.
    }

    public static function retrieveByPk($id)
    {
        // TODO: Implement retrieveByPk() method.
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function __construct()
    {
        // TODO: Implement __construct() method.
    }
}