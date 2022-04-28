<?php
/**
 * Developer: Camilo Lozano III - www.camilord.com
 *                              - github.com/camilord
 *                              - linkedin.com/in/camilord
 *
 * utilus - SystemUtilusTest.php
 * Username: Camilo
 * Date: 28/04/2022
 * Time: 10:45 AM
 */

namespace camilord\utilus\IO;

use camilord\utilus\IO\SystemUtilus;
use PHPUnit\Framework\TestCase;

/**
 * Class SystemUtilusTest
 * @package camilord\utilus\IO
 */
class SystemUtilusTest extends TestCase
{
    public function testGetMacAddress() {
        $mac_addresses = SystemUtilus::getHostMacAddress();
        $this->assertTrue(is_array($mac_addresses));
        foreach($mac_addresses as $mac_address) {
            $this->assertSame($mac_address, filter_var($mac_address, FILTER_VALIDATE_MAC));
        }
    }
}