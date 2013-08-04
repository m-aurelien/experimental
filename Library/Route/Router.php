<?php
/**
 * Created by Aurelien
 * Date: 28/06/13
 * Time: 14:00
 */

namespace Library\Route;

/**
 * Routes manager
 *
 * @package Library\Route
 * @author Aurelien Mecheri
 */
class Router{
    /**
     * @access private
     * @var array $routes
     */
    private $_routes = array();

    /**
     * @access public
     * @var int N0_ROUTE
     */
    const NO_ROUTE = 1;

    /**
     * Adds all routes present in the file routes.xml
     *
     * @param $appName
     */
    public function addRoutesConfig(){
        $xml = new \DOMDocument;
        $xml->load(SERVER_ROOT.'Applications/'.APP_NAME.'/Configs/routes.xml');

        $routes = $xml->getElementsByTagName('route');

        foreach ($routes as $route){
            $vars = array();
            if ($route->hasAttribute('vars')){
                $vars = explode(',', preg_replace('/\s/', '', $route->getAttribute('vars')));
            }

            if ($route->hasAttribute('cache')){
                $cacheDuration = (int) $route->getAttribute('cache');
            }else{
                $cacheDuration = 0;
            }

            $this->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('controller'), $route->getAttribute('action'), $cacheDuration, $vars));
        }
    }

    /**
     * Add a route
     *
     * @param Route $route
     */
    public function addRoute(Route $route){
        if (!in_array($route, $this->_routes)){
            $this->_routes[] = $route;
        }
    }

    /**
     * Tries to match the url passed in parameter with a route
     *
     * @param string $url
     * @return Route $route
     * @throws \RuntimeException
     */
    public function route($url){
        foreach ($this->_routes as $route){
            if (($varsValues = $route->match($url)) !== false){
                if ($route->hasVars()){
                    $varsNames = $route->varsNames();
                    $listVars = array();

                    array_shift($varsValues);
                    foreach ($varsValues as $key => $match){
                        $listVars[$varsNames[$key]] = $match;
                    }

                    $route->setVars($listVars);
                }
                return $route;
            }
        }
        throw new \RuntimeException('No route match with this URL', self::NO_ROUTE);
    }
}