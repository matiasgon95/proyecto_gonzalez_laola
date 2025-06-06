<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 */
class Services extends BaseService
{
    /**
     * Shopping Cart Service
     *
     * @param  bool $getShared
     * @return mixed
     */
    public static function cart($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('cart');
        }
        return new \CodeIgniterCart\Cart();
    }
    
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
}
