<?php
/**
 * Created by Aurelien
 * Date: 25/07/13
 * Time: 21:18
 */

namespace Library\WebService;

use Library\Loader;

/**
 * RestServer
 *
 * @package Library\WebService
 * @author Aurelien Mecheri
 */
class RestServer{
    /**
     * @access private
     * @var string $_namespace
     */
    private $_namespace;
    /**
     * @access private
     * @var Service $_service
     */
    private $_service;
    /**
     * @access private
     * @var \ReflectionMethod $_action
     */
    private $_action;
    /**
     * @access private
     * @var array $_params
     */
    private $_params = array();

    /**
     * Set $_namespace & exec _parseParams function
     *
     * @param string $namespace
     */
    public function __construct($namespace = ''){
        $this->_namespace = $namespace;
        $this->_parseParams();
    }

    /**
     * Handle incoming request
     */
    public function handle(){
        $this->_checkService();
        $this->_checkAction();
        $this->_checkMethod();
        $this->_checkAuth();

        $paramList = array();
        foreach ($this->_action->getParameters() as $param) {
            if(array_key_exists(strtolower($param->getName()), $this->_params)){
                $paramList[strtolower($param->getName())] = $this->_params[strtolower($param->getName())];
            }elseif($param->isDefaultValueAvailable()){
                $paramList[strtolower($param->getName())] = $param->getDefaultValue();
            }else{
                $this->_sendError(5, $param->getName());
            }
        }

        $this->_sendData(call_user_func_array(array($this->_service, $this->_action->getName()), $paramList));
    }

    /**
     * Parse params
     */
    private function _parseParams() {
        $this->_params = array_change_key_case($_REQUEST, CASE_LOWER);
        if ($_SERVER['REQUEST_METHOD'] == "PUT" || $_SERVER['REQUEST_METHOD'] == "DELETE") {
            parse_str(file_get_contents('php://input'), $temp);
            foreach ($temp as $key => $val) {
                $this->_params[strtolower($key)] = $val;
            }
        }
    }

    /**
     * Check that service is requested and exist
     */
    private function _checkService(){
        if (array_key_exists("service", $this->_params)) {
            $class = $this->_namespace.$this->_params['service'];
            unset($this->_params['service']);
            if(Loader::class_exist($class)){
                $this->_service = new $class();
            }else{
                $this->_sendError(2, $this->_params['service']);
            }
        }else{
            $this->_sendError(1);
        }
    }

    /**
     * Check that action is requested and exist
     */
    private function _checkAction(){
        if (array_key_exists("action", $this->_params)){
            if (method_exists($this->_service, $this->_params['action'])){
                $this->_action = new \ReflectionMethod($this->_service, $this->_params['action']);
                unset($this->_params['action']);
            }else{
                $this->_sendError(4, $this->_params['action']);
            }
        }else{
            $this->_sendError(3);
        }
    }

    /**
     * Check that method used is congruent
     */
    private function _checkMethod(){
        preg_match('/@method[ \t]+(GET|POST|PUT|DELETE)/', $this->_action->getDocComment(), $match);

        if($_SERVER['REQUEST_METHOD'] != $match[1]){
            $this->_sendError(7);
        }
    }

    /**
     * Check that is authorized
     */
    private function _checkAuth(){
        $noAuth = preg_match('/@noAuth/', $this->_action->getDocComment());
        if(!$noAuth){
            if(!$this->_service->authorize()){
                $this->_sendError(6);
            }
        }
    }

    /**
     * Construct & send header
     */
    public function _setHeader(){
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Type: application/json');
    }

    /**
     * Send data
     *
     * @param array $data
     */
    public function _sendData($data){
        $this->_setHeader();
        echo json_encode($data);
    }

    /**
     * Send error
     *
     * @param int $code
     * @param mixed $params
     */
    public function _sendError($code, $params = null){
        $this->_setHeader();
        echo json_encode(array('error' => array('code' => $code, "message" => sprintf($this->errors[$code], $params))));
    }

    /**
     * Setter $_namespace
     *
     * @param string $namespace
     */
    public function setNamespace($namespace){
        $this->_namespace = $namespace;
    }

    /**
     * Getter $_namespace
     *
     * @return string $_namespace
     */
    public function getNamespace(){
        return $this->_namespace;
    }

    /**
     * Getter $_service
     *
     * @return mixed $_service
     */
    public function getService(){
        return $this->_service;
    }

    /**
     * Getter $_action
     *
     * @return mixed $_action
     */
    public function getAction(){
        return $this->_action;
    }

    /**
     * Getter $_params
     *
     * @return array $_params
     */
    public function getParams(){
        return $this->_params;
    }

    /**
     * Set of errors
     *
     * @var array
     */
    private $errors = array(
        1 => 'No service was requested.',
        2 => 'The service %s does not exist.',
        3 => 'No action was requested.',
        4 => 'The action %s does not exist.',
        5 => 'The parameter %s is missing.',
        6 => 'No authorization to access to this action.',
        7 => 'Bad request method to access to this action.'
    );
}