<?php


namespace camilord\utilus\Security;

use camilord\utilus\Data\ArrayUtilus;
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

    // test validate and must be invalid if revalidated again
    public function testCsrfValid() {
        $obj = $this->testObject();
        $identify = 'test_identity';

        $csrf_token = $obj->generate($identify);
        print_r($csrf_token);

        sleep(3);

        $actual = $obj->is_csrf_valid($identify, $csrf_token);
        $this->assertTrue($actual, '1:) '.$obj->getErrorMessage().' | '.print_r([$actual, $identify], true));

        // verify again, should be false because it been destroyed
        $actual = $obj->is_csrf_valid($identify, $csrf_token);
        $this->assertFalse($actual, '2:) '.$obj->getErrorMessage().' | '.print_r([$actual, $identify], true));
    }

    // test expired validation
    public function testCsrfInvalid() {
        $obj = $this->testObject();
        $identify = 'test_identity';

        $csrf_token = $obj->generate($identify);

        sleep(8);

        $actual = $obj->is_csrf_valid($identify, $csrf_token);
        $this->assertFalse($actual);
    }

    public function testArrayedTokens() {
        $obj = $this->testObject();

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 100; $j++) {
                $identify = 'test_' . $i;
                $csrf_token = $obj->generate('test_' . $i);

                if ($j >= 99) {
                    $result = $obj->is_csrf_valid($identify, $csrf_token);
                    $this->assertTrue($result);
                }
            }
        }

        $this->assertTrue(isset($_SESSION[CsrfToken::PREFIX]));

        if (isset($_SESSION[CsrfToken::PREFIX])) {
            $this->assertTrue(is_array($_SESSION[CsrfToken::PREFIX]));

            foreach($_SESSION[CsrfToken::PREFIX] as $area => $sessions)
            {
                $this->assertSame(50, count($sessions));
                echo "Area Name: {$area}\n";
                echo "Area Sessions Count: ".count($sessions)."\n";
                print_r($sessions);
                echo "---\n\n";
            }
        }

        $obj->destroy_all();

        $this->assertFalse(ArrayUtilus::haveData($_SESSION[CsrfToken::PREFIX]));
    }
}