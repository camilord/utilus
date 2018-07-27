<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 3:46 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Encryption;

use PHPUnit\Framework\TestCase;
use camilord\utilus\Encryption\Crypt;

class CryptTest extends TestCase
{
    private $server_salt = 'ADoXALbJiVe3Qcby5DmsTn7xSdCZtgxb7fXN1nP0ju0HL5emNeneq97rxWvdHKXL';
    private $user_salt = 'WlDdWh14RfTHtwpY2EaX4UpY2F3X5moy';
    private $password = 'secret';

    public function testEncrypt() {
        $crypt = new Crypt();

        $expected_password = 'NGFiZjBhMGY4YzVhOWEyMDE0NTM0YWY0ZTdiNDk4ZWJjYjY0MDc0Mg==';
        $encrypted_password = $crypt->encrypt($this->password, $this->server_salt, $this->user_salt);

        $this->assertEquals($encrypted_password, $expected_password);
    }

    public function testEncrypt_v4() {
        $crypt = new Crypt();

        $expected_password = '$2y$12$V2xEZFdoMTRSZlRBRG9YQOMMr3veC1W593b8tfwLXJapE6IEn4d3e';
        $encrypted_password = $crypt->encrypt_v4($this->password, $this->server_salt, $this->user_salt);

        $this->assertEquals($encrypted_password, $expected_password);
    }

    public function testEncrypt_v3() {
        $crypt = new Crypt();

        $expected_password = 'NGFiZjBhMGY4YzVhOWEyMDE0NTM0YWY0ZTdiNDk4ZWJjYjY0MDc0Mg==';
        $encrypted_password = $crypt->encrypt_v3($this->password, $this->server_salt, $this->user_salt);

        $this->assertEquals($encrypted_password, $expected_password);
    }

    public function testEncrypt_v2() {
        $crypt = new Crypt();

        $expected_password = 'MDQ4Yjk2NjFmZjY2ZTkzNzFlNjBkYjdiOTdlMjBhMTY=';
        $encrypted_password = $crypt->encrypt_v2($this->password, $this->server_salt, $this->user_salt);

        $this->assertEquals($encrypted_password, $expected_password);
    }

    public function testEncrypt_v1() {
        $crypt = new Crypt();

        $expected_password = 'YmQxYzExYTM0MGQ5ZGJlZjlhN2EyOGFiZGM2ZGIxY2ZlOWRjNWExOQ==';
        $encrypted_password = $crypt->encrypt_v1($this->password, $this->server_salt, $this->user_salt);

        $this->assertEquals($encrypted_password, $expected_password);
    }
}