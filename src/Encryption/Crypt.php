<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:36 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Encryption;

/**
 * Class Crypt
 * @package camilord\utilus\Encryption
 */
class Crypt
{
    /**
     * @param $password string
     * @param $server_salt string
     * @param $user_salt string
     * @param $version int
     * @return string
     */
    public static function encrypt($password, $server_salt, $user_salt, $version = 3) {
        $method = 'encrypt_v'.$version;
        return Crypt::$method($password, $server_salt, $user_salt);
    }

    /**
     * bcrypt implementation
     * @param $password
     * @param $server_salt
     * @param $user_salt
     * @return string
     */
    public static function encrypt_v4($password, $server_salt, $user_salt) {
        $pepper = substr($user_salt, 0, 11).substr($server_salt, 0, 11);
        $salt = substr(base64_encode($pepper), 0, 22);
        $hash = crypt($password, '$2y$12$' . $salt);
        return $hash;
    }

    /**
     * @param $password
     * @param $server_salt
     * @param $user_salt
     * @return string
     */
    public static function encrypt_v3($password, $server_salt, $user_salt) {
        $new_password = $server_salt.$password.$user_salt;
        return base64_encode(sha1($new_password));
    }

    /**
     * @param $password
     * @param $server_salt
     * @param $user_salt
     * @return string
     */
    public static function encrypt_v2($password, $server_salt, $user_salt) {
        $new_password = $server_salt.$password.$user_salt;
        $c_password = crypt($new_password, $server_salt.$user_salt);
        $sha1_password = sha1($server_salt.$c_password);
        $md5_password = md5($sha1_password.$user_salt);
        return base64_encode($md5_password);
    }

    /**
     * @param $password
     * @param $server_salt
     * @param $user_salt
     * @return string
     */
    public static function encrypt_v1($password, $server_salt, $user_salt) {
        for($i = 0; $i < 10; $i++) {
            $new_password = $server_salt.$password.$user_salt;
            $md5_password = md5($new_password).$user_salt;
            $sha1_password = sha1($server_salt.$md5_password);
            $password = $sha1_password;
        }
        return base64_encode($password);
    }
}