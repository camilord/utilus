<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 11:35 PM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\Net\EmailUtilus;
use camilord\utilus\Security\Sanitizer;

class EmailUtilusTest extends TestCase
{
    /**
     * @param array $data
     * @param string $expected
     * @dataProvider getTestDataForEmailCleanerHtml
     */
    public function testEmailCleanerHtml($data, $expected)
    {
        $result = EmailUtilus::email_cleaner_html($data);
        $this->assertEquals($result, $expected);
    }

    /**
     * @param array $data
     * @param string $expected
     * @dataProvider getTestDataForEmailBodyCleaner
     */
    public function testEmailBodyCleaner($data, $expected)
    {
        $result = EmailUtilus::email_body_cleaner($data);
        $this->assertEquals($result, $expected);
    }

    public function testExtractEmailsFrom() {
        $result = EmailUtilus::extract_emails_from($this->getHeaderData());

        $this->assertEquals(count($result), 10);
        $this->assertTrue(is_array($result));
        $this->assertTrue(in_array('Dexoxole@xoxo.govt.nz', $result));
        $this->assertTrue(in_array('caxoxord@xoxo.co.nz', $result));
        $this->assertTrue(in_array('support@xoxo.co.nz', $result));
        $this->assertTrue(in_array('Shxoxows@xoxo.govt.nz', $result));
        $this->assertTrue(in_array('d6280104a98745ff9fbf8930572588c8@WDCEXCHANGE2013.xoxo.int', $result));
    }

    public function testIsBouncedEmail()
    {
        $result = EmailUtilus::is_bounced_email($this->getBouncedData());
        $this->assertTrue($result);

        $result = EmailUtilus::is_bounced_email($this->getHeaderData());
        $this->assertFalse($result);
    }

    /**
     * @param string $email
     * @param bool $expected
     * @dataProvider getSampleEmails
     */
    public function testIsValidEmail($email, $expected) {
        $result = EmailUtilus::isValidEmail($email);
        $this->assertEquals(($result == $email), $expected);
    }

    /**
     * @param string $email
     * @param bool $expected
     * @dataProvider getObfuscateEmails
     */
    public function testObfuscateEmail($email, $expected) {
        $result = EmailUtilus::obfuscateEmail($email);
        $this->assertEquals($result, $expected);
    }

    public function testIsAutoReply()
    {
        $result = EmailUtilus::is_auto_reply($this->getTestDataForAutoReplyHeadersSuppress());
        $this->assertTrue($result);

        $result = EmailUtilus::is_auto_reply($this->getTestDataForAutoReplyHeadersXReply());
        $this->assertTrue($result);

        $result = EmailUtilus::is_auto_reply($this->getHeaderData());
        $this->assertFalse($result);

        $result = EmailUtilus::is_auto_reply($this->getBouncedData());
        $this->assertFalse($result);
    }


    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getSampleEmails() {
        return [
            ['john@abcs.co.nz', true],
            ['user@google.com', true],
            ['test@sample-sample.com', true]
        ];
    }

    public function getObfuscateEmails() {
        return [
            ['john@abcs.co.nz', 'jo**@abcs.co.nz'],
            ['user@google.com', 'us**@google.com'],
            ['test@sample-sample.com', 'te**@sample-sample.com'],
            ['#twitter@twitter.com', '#twi****@twitter.com'],
            ['user@test.test.test.test-test', 'us**@test.test.test.test-test'],
        ];
    }

    public function getTestDataForEmailCleanerHtml() {
        return [
            ['<style type="text/css" src="style.css"></style><body>test</body>', 'test'],
            ['<div>test</div>', 'test'],
            ['<b>test</b>', '<b>test</b>']
        ];
    }

    public function getTestDataForEmailBodyCleaner() {
        return [
            ['hello                             world', 'hello world'],
            ["hello\t \t \t world", 'hello world'],
            ["hello\n\n\t\t\nworld", "hello\n\nworld"]
        ];
    }

    public function getHeaderData() {
        $headers = <<<EOF
Return-Path: <Dexoxole@xoxo.govt.nz>
Delivered-To: caxoxord@xoxo.co.nz
Received: from mail.xoxo.co.nz (mail.xoxo.co.nz [127.0.0.1])
    by mail.xoxo.co.nz (Postfix) with ESMTP id 5770FF9501
    for <caxoxord@xoxo.co.nz>; Thu, 17 May 2018 11:48:00 +1200 (NZST)
X-Virus-Scanned: amavisd-new at mail.xoxo.co.nz
Received: from mail.xoxo.co.nz ([127.0.0.1])
    by mail.xoxo.co.nz (mail.abcs.co.nz [127.0.0.1]) (amavisd-new, port 10024)
    with ESMTP id 75nvu9GYb--4 for <caxoxord@xoxo.co.nz>;
    Thu, 17 May 2018 11:47:58 +1200 (NZST)
Received: from mail.xoxo.govt.nz (mail.xoxo.govt.nz [103.0.0.0])
    by mail.xoxo.co.nz (Postfix) with ESMTP id 09A88F9486
    for <support@xoxo.co.nz>; Thu, 17 May 2018 11:47:57 +1200 (NZST)
Received: from WDCEXCHANGE2013.xoxo.int (Not Verified[10.x.0.x]) by mail.xoxo.govt.nz with Trustwave SEG (v7,5,8,10121)
    id <B5afcc2f20000>; Thu, 17 May 2018 11:46:58 +1200
Received: from WDCEXCHANGE2013.xoxo.int (10.160.0.15) by
    WDCEXCHANGE2013.xoxo.int (10.x.0.x) with Microsoft SMTP Server (TLS) id
    15.0.1293.2; Thu, 17 May 2018 11:46:58 +1200
Received: from WDCEXCHANGE2013.xoxo.int ([xx::6539:xx:cf64:31fe]) by
    WDCEXCHANGE2013.xoxo.int ([xx::6539:xx:cf64:31fe%13]) with mapi id
    15.00.1293.006; Thu, 17 May 2018 11:46:58 +1200
From: Demi Axoxole <Dexoxole@xoxo.govt.nz>
To: "support@xoxo.co.nz" <support@xoxo.co.nz>
CC: Sheri Mexoxows <Shxoxows@xoxo.govt.nz>
Subject: BC180200 Payment Status
Thread-Topic: BC180200 Payment Status
Thread-Index: AdPtcC1MSE5c0pkYThyTQ9zM6/ir+w==
Date: Wed, 16 May 2018 23:46:58 +0000
Message-ID: <d6280104a98745ff9fbf8930572588c8@WDCEXCHANGE2013.xoxo.int>
Accept-Language: en-NZ, en-US
Content-Language: en-US
X-MS-Has-Attach: yes
X-MS-TNEF-Correlator:
x-ms-exchange-transport-fromentityheader: Hosted
x-originating-ip: [10.160.1.127]
Content-Type: multipart/related;
    boundary="_007_d6280104a98745ff9fbf8930572588c8WDCEXCHANGE2013wdcint_";
    type="multipart/alternative"
MIME-Version: 1.0
EOF;
        return $headers;
    }

    public function getBouncedData() {
        $headers = <<<EOF
Return-Path: <MAILER-DAEMON>
Date: Tue, 13 Feb 2018 14:07:19 +1300
Content-Type: multipart/report; report-type=delivery-status;
    boundary="02ddc4c3-1c25-44d9-a87b-e19011497c34"
Content-Language: en-US
Message-ID: <020fd716-e88a-4199-8971-95eeb3759b6e@xxxx.govt.nz>
In-Reply-To: <031d01d3a466\$dcb58760$96209620$@abcs.co.nz>
References: <9FC9429C1B04384787496D1BC2970C4C97581B4F@Exchange01.xxxx.govt.nz>
    <031d01d3a466\$dcb58760$96209620$@abcs.co.nz>
Thread-Index: AQHXl+LPt2gZg1ctnJZSwldsza9BF6OZneDAgAAAWBE=
Subject: Undeliverable: RE: wireshark
EOF;
        return $headers;
    }

    public function getTestDataForAutoReplyHeadersSuppress() {
        $headers = <<<EOF
Subject: Selwyn Autoreply
Thread-Topic: Selwyn Autoreply
Thread-Index: AQHTVoX48qQf/rL9R02Db7+QqglAPw==
Date: Sun, 5 Nov 2017 22:32:32 +0000
Message-ID: <b5d66930e76243eb8bddd885ad3fafdd@SDCEX2013.xxx.xxx.local>
X-MS-Has-Attach:
X-Auto-Response-Suppress: All
X-MS-Exchange-Inbox-Rules-Loop: buildxxxment@xxx.govt.nz
X-MS-TNEF-Correlator:
x-ms-exchange-transport-fromentityheader: Hosted
x-ms-exchange-parent-message-id: <7895a7aa177b6668da30d8332fd365b6@xxx.co.nz>
auto-submitted: auto-generated
x-ms-exchange-generated-message-source: Mailbox Rules Agent
Content-Type: text/plain; charset="us-ascii"
Content-Transfer-Encoding: quoted-printable
MIME-Version: 1.0
EOF;
        return $headers;
    }

    public function getTestDataForAutoReplyHeadersXReply() {
        $headers = <<<EOF
Subject: Selwyn Autoreply
Thread-Topic: Selwyn Autoreply
Thread-Index: AQHTVoX48qQf/rL9R02Db7+QqglAPw==
Date: Sun, 5 Nov 2017 22:32:32 +0000
Message-ID: <b5d66930e76243eb8bddd885ad3fafdd@SDCEX2013.sdc.xxx.local>
X-MS-Has-Attach:
x-autoreply: yes
X-MS-Exchange-Inbox-Rules-Loop: buixxxument@xxx.govt.nz
X-MS-TNEF-Correlator:
x-ms-exchange-transport-fromentityheader: Hosted
x-ms-exchange-parent-message-id: <7895a7aa177b6668da30d8332fd365b6@xxx.co.nz>
auto-submitted: auto-generated
x-ms-exchange-generated-message-source: Mailbox Rules Agent
Content-Type: text/plain; charset="us-ascii"
Content-Transfer-Encoding: quoted-printable
MIME-Version: 1.0
EOF;
        return $headers;
    }
}