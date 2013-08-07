<?php
/**
 * Created by Aurelien
 * Date: 28/07/13
 * Time: 18:39
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