<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 5:17 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Encryption;

use PHPUnit\Framework\TestCase;
use camilord\utilus\Encryption\DataCrypt56;

class DataCrypt56Test extends TestCase
{

    /**
     * @deprecated
     * @param string $str
     * @param string $encrypted_str
     * @dataProvider getTestData
     */
    public function testEncode($str, $encrypted_str) {

        if (PHP_MAJOR_VERSION >= 7) {
            $this->markTestSkipped('Test for PHP v5.6 only');
        }

        $cryptor = new DataCrypt56();
        $result_str = $cryptor->encode($str);

        $this->assertEquals($result_str, $encrypted_str);
    }

    /**
     * @deprecated
     * @param string $str
     * @param string $encrypted_str
     * @dataProvider getTestData
     */
    public function testDecode($str, $encrypted_str) {

        if (PHP_MAJOR_VERSION >= 7) {
            $this->markTestSkipped('Test for PHP v5.6 only');
        }

        $cryptor = new DataCrypt56();
        $result_str = $cryptor->decode($encrypted_str);

        $this->assertEquals($result_str, $str);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestData() {
        return [
            [ 'ADoXALbJiVe3Qcby5DmsTn7xSdCZtgxb7fXN1nP0ju0HL5emNeneq97rxWvdHKXL', '_nGvezySqp1_Hz2D7dk_CIJmjWKqwK-Qk1n91vYSbJOLOdnmVrgglESxlfLHsX6VVj0-sRaj5mPuDNkkz-h-hw' ],
            [ '_Ul:. [D%fZtj`0PPcKUOk|G2z,6prsl;:U3d%2Kko-x(L0z?/Jw*<DTHK9Tk$8J', 'LVle7cOmMP55O1fJZUvgZg2MGLP7L5AI8NFW0N-mR2ZHLQzU2oqyY6w4nHoTNyDRr3XLsOYwLsjAQZr9YZiwDA' ],
            [ '@]L!U-^9kGp;d/c{HGu-J1^tDj%|-;iu~[+t)wETz*3PV.G^,+1`O:`as~<a-4Vm', '8OFwrEfel9x6WZaZjNbfH4adpixNleFnXT5yiT3V20_EU2gpLRSN9yatxLNldP20Dt8RDDaD6VMJwk-FlLAznA' ],
            [ 'Um5I`uwIRc-{F`n2+r1uKO+|KF6.(T[]S0tx;7N+p@pu|Fh+nH[3>J~A0UxrXeo)', 'i8jxsaYwb3QeG3hEfQtLL3qj2rzLF5VGB9e58Z67OTuPNADANAvhGTuL6z-s7OFF0oBREIxmNFmDktkXnVBSQQ' ],
            [ 'L}% [AkOO+ke|$xf2dV[^+T,}L&Eaa_({<mLPnB|r*g;aL;Y%;b(5U]GQjXx<p}H', 'PAGeS28L8GRzO7yY4BfJkycJdcEHMfVhulxizEd1nYLTR2UYt2K3qr-HW1MStUUJrLsaGAIlqOiHYNVmYd525Q' ],
            [ '~i%[lZ+X68k+PojX 6W;*-66]GBoFej+lO]z8h-VIAnnY,lN(]pkg!*E?SGZduk#', 'Lv-PJKwcZkcyICPIje2Cw8r5uUMhdpcMeXvDYU67RsPtdgUYPyCPa8OBMIehRCwgbD7suVKn16efl-ediFoHLw' ],
            [ 'sCW5VKA`])_pW.j-Jppp-Odp0Ki#TKZKA?$W8-7FR:6m+]~5jjATRq7}I7/ps62,', 'd1NRhADoWcppQ8o1d7hJ-kuEQZnp4o5HiUOgfkunM1UBP_8mMH_oY-Ogy68WHsYzKXgpdaTgmTrGCoCnhN3cBw' ],
            [ 'N+auRoi^)9OB!Q6shE3b`,!U_V+!(F j?eo~5EolBX@=9P}DcDV,1aW1>_Ts{kip', '_1bCNmLXRpmzFDGvnmsNbUoEOJ5foZQYPHCX5RNS8_suMDZbzMoGfbnjBjz2FBVRbVP_e0tU1HLWByLGpN3Rlg' ],
            [ '_/,}<]UJ%nS7Z?SzNa+E?L0++GgGWxN0W__9|#jQuJO=b|80/P-$dAR|v(oE|z0:', 'QL04pwbI-IlkEPdqDNd_QAD3KWgBwjXFqBmnHm_YPfpfccdvsxCu61Sxa15BY56C-sm2DlvMfC6a7orYVWlqug' ],
            [ 'the quick brown fox jumps over the lazy dog.', 'qSBnTS9Yh5562cVtCxfPZko2fZEWGoOqTbTjhJRxSeZlOxNet_f2D8whfm-QxcDYiw_FXAVjQDa5tBuvLWOEmg' ],
        ];
    }
}