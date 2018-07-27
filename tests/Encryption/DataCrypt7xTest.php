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
use camilord\utilus\Encryption\DataCrypt7x;

class DataCrypt7xTest extends TestCase
{

    /**
     * @param string $str
     * @param string $encrypted_str
     * @dataProvider getTestData
     */
    public function testEncode($str, $encrypted_str) {
        $cryptor = new DataCrypt7x();
        $result_str = $cryptor->encode($str);

        $this->assertEquals($result_str, $encrypted_str);
    }

    /**
     * @param string $str
     * @param string $encrypted_str
     * @dataProvider getTestData
     */
    public function testDecode($str, $encrypted_str) {
        $cryptor = new DataCrypt7x();
        $result_str = $cryptor->decode($encrypted_str);

        $this->assertEquals($result_str, $str);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestData() {
        return [
            [ 'ADoXALbJiVe3Qcby5DmsTn7xSdCZtgxb7fXN1nP0ju0HL5emNeneq97rxWvdHKXL', 'dGpXd29PMkJ1TmwrbEp1eDdJa2xQK2xxcXdGTzhka0RNd3BwZ2xFMXJ4NHBUSUdoVEZBQmhDM2x1TGZmbkJQNFhhS2VvcE95TUo0Z2dXMTdvVXRka1N2eHZqaGxlQ2NPQ0NnQm9SOEdLemM9' ],
            [ '_Ul:. [D%fZtj`0PPcKUOk|G2z,6prsl;:U3d%2Kko-x(L0z?/Jw*<DTHK9Tk$8J', 'bmxmN2k0WUJmKzhIQThYbWkzMFF5V1EybXIwb2F5azd5STM3UCtrazFHYXNoaUJ0dUNxcXdEL01MNWkrdjM0akZpZ1h4SHpvTU1aZ2sxUmFpM2krMlNtQmZsVjJITjNBQlladkM4dWhucDg9' ],
            [ '@]L!U-^9kGp;d/c{HGu-J1^tDj%|-;iu~[+t)wETz*3PV.G^,+1`O:`as~<a-4Vm', 'Wkx4c1lwUmtoOWpveHlISlZnK1dmdDJQZTE2cElkVC85SlZJZXdTVjRtQVhMNklzSlAzcHl2YWRFdHNpSlMreTY3VVVMZWhUbERCNG9xNFVrclJabFllTFA2RTdhZ2RPVVI2MXpuMzVNUGs9' ],
            [ 'Um5I`uwIRc-{F`n2+r1uKO+|KF6.(T[]S0tx;7N+p@pu|Fh+nH[3>J~A0UxrXeo)', 'R0lqVGltam5qbStOdExJWUxHekdxdG9tNjZyNmtYUytQWFhUbkFXR3Q5dHpWYzhCclZqZ0VZdjdMUGFrV2hGNFJRY2pBTmdrTVlWa2o0WGk0MXZueTZZR2I4a1JhS0swd25aaEd0by9CZE09' ],
            [ 'L}% [AkOO+ke|$xf2dV[^+T,}L&Eaa_({<mLPnB|r*g;aL;Y%;b(5U]GQjXx<p}H', 'N3ZtVVVIWW9kSXVuSW5rSzNjeC9GMlYvdkYvSncxczVwUFdIZXRUemtKY1hVZEZGRUEzejhFT202dXpRcHh1VDNoc2lXUHBsd3Rqa3BFMXF0bW5saGZpVDF1TkZmSXJaYUw4YnRpM04vRjQ9' ],
            [ '~i%[lZ+X68k+PojX 6W;*-66]GBoFej+lO]z8h-VIAnnY,lN(]pkg!*E?SGZduk#', 'Lzlrd0JjV2lxQi96a1VUUGpDd0JCbGdaZ2lERXUvaExnMjRkbXE5UlMyZ0pOQWJqWGtDZG9pVTBhRXdxYjNmdTdXdW1PN2hYMVo4dE5DT2hKNWhRZ1VsUlJtQnJnaDY2MEhpQ29DUUdPajA9' ],
            [ 'sCW5VKA`])_pW.j-Jppp-Odp0Ki#TKZKA?$W8-7FR:6m+]~5jjATRq7}I7/ps62,', 'NG1McXVESVVWRjdxdkFuMWZLTGM5MkNzaURSMEFuU3pleFg5L0Yzc2tGenlvZE5adjVrSXoxWkd4Zy9lU3dLQ2lhQURwY0pxTk1LL0NxckRIVzFRNzcxY2VHZW1SSXZVQkJuRUpzVDBXUVE9' ],
            [ 'N+auRoi^)9OB!Q6shE3b`,!U_V+!(F j?eo~5EolBX@=9P}DcDV,1aW1>_Ts{kip', 'ZXhhbHF5WnR1NGVXajJoeklsN3F0NVJBZGpQMUZUbEZHV0RUYXhFUVl3b0NlRlVKYjlhODFyM0lDSTBnVjRWRXptOXZWL0dsODB2dWRPenQzSDQ0bmNtZ1J1aXdqYnhmK2M5VFR2bk5LWDQ9' ],
            [ '_/,}<]UJ%nS7Z?SzNa+E?L0++GgGWxN0W__9|#jQuJO=b|80/P-$dAR|v(oE|z0:', 'MjVyT08wc1YzNXpqMjRIRWI0SXh2WjRHeXFXTGpQUUhza0RlUlIyc3RWa2pCeW9JYWdidW10UExickRrV1hPWmpYR0hqd3FJRUN1YVcxUXhaQXMyMzlNc0l1MEQ3bFNKSnBHcWhJZUNyT0E9' ],
            [ 'the quick brown fox jumps over the lazy dog.', 'emptbDFkTnRsSnVTTFNTMmovNjBNc1IvUkpXbENnODBLZHZqN1NUOEpWaGFIRUliRHVINUp4QWtkZTlxbmJEbQ==' ],
        ];
    }
}