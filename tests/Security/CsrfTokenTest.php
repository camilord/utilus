<?php


namespace camilord\utilus\Security;

use PHPUnit\Framework\TestCase;

/**
 * Class CsrfTokenTest
 * @package Security
 */
class CsrfTokenTest extends TestCase
{
    /**
     * @return CsrfToken
     */
    public function testObject() {
        $obj = new CsrfToken(5);
        $this->assertTrue(($obj instanceof CsrfToken));

        return $obj;
    }

    public function testCsrfValid() {
        $obj = $this->testObject();
        $identify = 'test_identity';

        $csrf_token = $obj->generate($identify);
        print_r($csrf_token);

        sleep(3);

        $actual = $obj->is_csrf_valid($identify, $csrf_token);
        $this->assertTrue($actual);

        // verify again, should be false because it been destroyed
        $actual = $obj->is_csrf_valid($identify, $csrf_token);
        $this->assertFalse($actual);
    }

    public function testCsrfInvalid() {
        $obj = $this->testObject();
        $identify = 'test_identity';

        $csrf_token = $obj->generate($identify);

        sleep(8);

        $actual = $obj->is_csrf_valid($identify, $csrf_token);
        $this->assertFalse($actual);
    }
}