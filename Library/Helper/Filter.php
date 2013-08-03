<?php
/**
 * Created by Aurelien
 * Date: 21/07/13
 * Time: 13:11
 */

namespace Library\Helper;

/**
 * Filter
 *
 * @package Library\Helper
 * @author Aurelien Mecheri
 */
abstract class Filter {

    /**
     * Int filter
     *
     * @static
     * @param $source
     * @return int
     */
    static function int($source){
        // Only use the first integer value
        preg_match('/-?[0-9]+/', (string) $source, $matches);
        return (!empty($matches)) ? (int) $matches[0] : (int) 0;
    }

    /**
     * Float filter
     *
     * @static
     * @param $source
     * @return float
     */
    static function float($source){
        // Only use the first floating point value
        preg_match('/-?[0-9]+(\.[0-9]+)?/', (string) $source, $matches);
        return (!empty($matches)) ? (float) $matches[0] : (float) 0;
    }

    /**
     * Bool filter
     *
     * @static
     * @param $source
     * @return bool
     */
    static function bool($source){
        return (bool) $source;
    }

    /**
     * Alphanumeric filter
     *
     * @static
     * @param $source
     * @return string
     */
    static function alnum($source){
        return (string) preg_replace( '/[^A-Z0-9]/i', '', $source );
    }

    /**
     * String filter with htmlentities
     *
     * @static
     * @param $source
     * @return string
     */
    static function string($source){
        return (string) htmlentities($source);
    }
}