<?php
/**
 * Created by Aurelien
 * Date: 01/08/13
 * Time: 09:43
 */

namespace Library\ApplicationComponent\Database;


interface DaoInterface {
    // **********************
    // CONST DECLARATION
    // **********************

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    // **********************
    // CONSTRUCTOR METHOD
    // **********************
    public function __construct();

    // **********************
    // GETTER METHODS
    // **********************

    // **********************
    // SETTER METHODS
    // **********************

    // **********************
    // TO STRING METHOD
    // **********************
    public function toString();

    // **********************
    // SELECT METHOD / LOAD ALL
    // **********************
    public static function doSelect($sql);

    // **********************
    // RETRIEVE BY PRIMARY KEY
    // **********************
    public static function retrieveByPk($id);

    // **********************
    // SAVE
    // **********************
    public function save();

    // **********************
    // DELETE
    // **********************
    public function delete();
}