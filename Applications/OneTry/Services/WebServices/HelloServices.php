<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aurelien
 * Date: 28/07/13
 * Time: 12:11
 * To change this template use File | Settings | File Templates.
 */

namespace Applications\OneTry\Services\WebServices;

use Library\WebService\ServiceInterface;

class HelloServices implements ServiceInterface {

    public function authorize(){
        return false;
    }

    /**
     * Returns a JSON string object to the browser when hitting the root of the domain
     *
     * @noAuth
     * @method POST
     */
    public function sayHello($name)
    {
        return "Hello, " . $name;
    }

    /**
     * Returns a JSON string object to the browser when hitting the root of the domain
     *
     * @method GET
     */
    public function test()
    {
        return "Hello World";
    }

}