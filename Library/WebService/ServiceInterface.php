<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aurelien
 * Date: 28/07/13
 * Time: 18:39
 * To change this template use File | Settings | File Templates.
 */

namespace Library\WebService;

/**
 * Interface ServiceInterface
 *
 * @package Library\WebService
 * @author Aurelien Mecheri
 */
interface ServiceInterface {
    /**
     * Check authorization
     */
    public function authorize();
}