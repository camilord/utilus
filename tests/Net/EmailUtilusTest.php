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
        $this->assertTrue(in_array('Demi.Arbuckle@whakatane.govt.nz', $result));
        $this->assertTrue(in_array('camilord@abcs.co.nz', $result));
        $this->assertTrue(in_array('support@abcs.co.nz', $result));
        $this->assertTrue(in_array('Sheri-Anne.Meadows@whakatane.govt.nz', $result));
        $this->assertTrue(in_array('d6280104a98745ff9fbf8930572588c8@WDCEXCHANGE2013.wdc.int', $result));
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
Return-Path: <Demi.Arbuckle@whakatane.govt.nz>
Delivered-To: camilord@abcs.co.nz
Received: from mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1])
    by mail.abcs.co.nz (Postfix) with ESMTP id 5770FF9501
    for <camilord@abcs.co.nz>; Thu, 17 May 2018 11:48:00 +1200 (NZST)
X-Virus-Scanned: amavisd-new at mail.abcs.co.nz
Received: from mail.abcs.co.nz ([127.0.0.1])
    by mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1]) (amavisd-new, port 10024)
    with ESMTP id 75nvu9GYb--4 for <camilord@abcs.co.nz>;
    Thu, 17 May 2018 11:47:58 +1200 (NZST)
Received: from mail.whakatane.govt.nz (mail.whakatane.govt.nz [103.54.224.5])
    by mail.abcs.co.nz (Postfix) with ESMTP id 09A88F9486
    for <support@abcs.co.nz>; Thu, 17 May 2018 11:47:57 +1200 (NZST)
Received: from WDCEXCHANGE2013.wdc.int (Not Verified[10.160.0.15]) by mail.whakatane.govt.nz with Trustwave SEG (v7,5,8,10121)
    id <B5afcc2f20000>; Thu, 17 May 2018 11:46:58 +1200
Received: from WDCEXCHANGE2013.wdc.int (10.160.0.15) by
    WDCEXCHANGE2013.wdc.int (10.160.0.15) with Microsoft SMTP Server (TLS) id
    15.0.1293.2; Thu, 17 May 2018 11:46:58 +1200
Received: from WDCEXCHANGE2013.wdc.int ([fe80::6539:4948:cf64:31fe]) by
    WDCEXCHANGE2013.wdc.int ([fe80::6539:4948:cf64:31fe%13]) with mapi id
    15.00.1293.006; Thu, 17 May 2018 11:46:58 +1200
From: Demi Arbuckle <Demi.Arbuckle@whakatane.govt.nz>
To: "support@abcs.co.nz" <support@abcs.co.nz>
CC: Sheri-Anne Meadows <Sheri-Anne.Meadows@whakatane.govt.nz>
Subject: BC180200 Payment Status
Thread-Topic: BC180200 Payment Status
Thread-Index: AdPtcC1MSE5c0pkYThyTQ9zM6/ir+w==
Date: Wed, 16 May 2018 23:46:58 +0000
Message-ID: <d6280104a98745ff9fbf8930572588c8@WDCEXCHANGE2013.wdc.int>
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
Delivered-To: camilord@abcs.co.nz
Received: from mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1])
    by mail.abcs.co.nz (Postfix) with ESMTP id 7BAF8F8C0F
    for <camilord@abcs.co.nz>; Tue, 13 Feb 2018 14:10:36 +1300 (NZDT)
X-Virus-Scanned: amavisd-new at mail.abcs.co.nz
X-Amavis-PenPals: age 0 0:00:59
Authentication-Results: mail.abcs.co.nz (amavisd-new);
    dkim=pass (1024-bit key) header.d=nz.smxemail.com
Received: from mail.abcs.co.nz ([127.0.0.1])
    by mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1]) (amavisd-new, port 10024)
    with ESMTP id 4izvtwYzvbo2 for <camilord@abcs.co.nz>;
    Tue, 13 Feb 2018 14:10:35 +1300 (NZDT)
Received: from out1103.nz.smxemail.com (out1103.nz.smxemail.com [203.84.134.34])
    by mail.abcs.co.nz (Postfix) with ESMTPS id 1B9D9F8C0D
    for <camilord@abcs.co.nz>; Tue, 13 Feb 2018 14:10:35 +1300 (NZDT)
DKIM-Signature: v=1; a=rsa-sha256; d=nz.smxemail.com; s=alpha; c=relaxed/relaxed;
    q=dns/txt; i=@nz.smxemail.com; t=1518484042;
    h=From:Sender:Reply-To:Subject:Date:Message-ID:To:Cc;
    bh=v3Sp2siiMeX3Uqxh9t90rw/9in9D8Qz9UxzHQXb8pgw=;
    b=ZLBH//IkO6ITLRPxlOdZkzW8S+OyDAQhvme0cm4SXT2YK0k3RYnIHWHgnp/QCBcq
    nQ8mYlRHa1FLtGr2BU03fcrujIe8CitK25bgSWT+g3N8BCqbE7Nc+petSkEbHK9G
    Jdu/0wlIHi9l0wDLLKsZuIkY6GmrPHOCOJUQLQWT3mo=;
Received: from Exchange01.tauranga.govt.nz ([122.56.80.65])
    by omr.nz.smxemail.com with ESMTP (using TLSv1
    with cipher AES256-SHA (256/256 bits))
    id 5A823A49-B7181C61@mta1106.omr;
    Tue, 13 Feb 2018 01:07:21 +0000
MIME-Version: 1.0
From: <mailadmin@tauranga.govt.nz>
To: <camilord@abcs.co.nz>
Date: Tue, 13 Feb 2018 14:07:19 +1300
Content-Type: multipart/report; report-type=delivery-status;
    boundary="02ddc4c3-1c25-44d9-a87b-e19011497c34"
Content-Language: en-US
Message-ID: <020fd716-e88a-4199-8971-95eeb3759b6e@tauranga.govt.nz>
In-Reply-To: <031d01d3a466\$dcb58760$96209620$@abcs.co.nz>
References: <9FC9429C1B04384787496D1BC2970C4C97581B4F@Exchange01.tauranga.govt.nz>
    <031d01d3a466\$dcb58760$96209620$@abcs.co.nz>
Thread-Index: AQHXl+LPt2gZg1ctnJZSwldsza9BF6OZneDAgAAAWBE=
Subject: Undeliverable: RE: wireshark
EOF;
        return $headers;
    }

    public function getTestDataForAutoReplyHeadersSuppress() {
        $headers = <<<EOF
Return-Path: <buildingadmin_designdocument@selwyn.govt.nz>
Delivered-To: camilord@abcs.co.nz
Received: from mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1])
    by mail.abcs.co.nz (Postfix) with ESMTP id 40315F92E2
    for <camilord@abcs.co.nz>; Mon, 6 Nov 2017 11:33:17 +1300 (NZDT)
X-Virus-Scanned: amavisd-new at mail.abcs.co.nz
Received: from mail.abcs.co.nz ([127.0.0.1])
    by mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1]) (amavisd-new, port 10024)
    with ESMTP id d_Vb3VD8dwAa for <camilord@abcs.co.nz>;
    Mon, 6 Nov 2017 11:33:16 +1300 (NZDT)
Received: from mail.selwyn.govt.nz (unknown [122.56.2.153])
    by mail.abcs.co.nz (Postfix) with SMTP id 90FA2F92DD
    for <support@abcs.co.nz>; Mon, 6 Nov 2017 11:33:15 +1300 (NZDT)
Received: from mail.selwyn.govt.nz (Not Verified[10.50.0.103]) by mail.selwyn.govt.nz with MailMarshal (v7,2,3,6978)
    id <B59ff91800000>; Mon, 06 Nov 2017 11:32:32 +1300
Received: from SDCEX2013.sdc.selwyn.local (10.50.0.9) by
    SDCEX2013.sdc.selwyn.local (10.50.0.9) with Microsoft SMTP Server (TLS) id
    15.0.1320.4; Mon, 6 Nov 2017 11:32:32 +1300
Received: from SDCEX2013.sdc.selwyn.local ([::1]) by
    SDCEX2013.sdc.selwyn.local ([fe80::e48d:2473:b931:e3a%12]) with Microsoft
    SMTP Server id 15.00.1320.000; Mon, 6 Nov 2017 11:32:32 +1300
From: BCA <buildingadmin_designdocument@selwyn.govt.nz>
To: AlphaOne Support <support@abcs.co.nz>
Subject: Selwyn Autoreply
Thread-Topic: Selwyn Autoreply
Thread-Index: AQHTVoX48qQf/rL9R02Db7+QqglAPw==
Date: Sun, 5 Nov 2017 22:32:32 +0000
Message-ID: <b5d66930e76243eb8bddd885ad3fafdd@SDCEX2013.sdc.selwyn.local>
X-MS-Has-Attach:
X-Auto-Response-Suppress: All
X-MS-Exchange-Inbox-Rules-Loop: buildingadmin_designdocument@selwyn.govt.nz
X-MS-TNEF-Correlator:
x-ms-exchange-transport-fromentityheader: Hosted
x-ms-exchange-parent-message-id: <7895a7aa177b6668da30d8332fd365b6@abcs.co.nz>
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
Return-Path: <buildingadmin_designdocument@selwyn.govt.nz>
Delivered-To: camilord@abcs.co.nz
Received: from mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1])
    by mail.abcs.co.nz (Postfix) with ESMTP id 40315F92E2
    for <camilord@abcs.co.nz>; Mon, 6 Nov 2017 11:33:17 +1300 (NZDT)
X-Virus-Scanned: amavisd-new at mail.abcs.co.nz
Received: from mail.abcs.co.nz ([127.0.0.1])
    by mail.abcs.co.nz (mail.abcs.co.nz [127.0.0.1]) (amavisd-new, port 10024)
    with ESMTP id d_Vb3VD8dwAa for <camilord@abcs.co.nz>;
    Mon, 6 Nov 2017 11:33:16 +1300 (NZDT)
Received: from mail.selwyn.govt.nz (unknown [122.56.2.153])
    by mail.abcs.co.nz (Postfix) with SMTP id 90FA2F92DD
    for <support@abcs.co.nz>; Mon, 6 Nov 2017 11:33:15 +1300 (NZDT)
Received: from mail.selwyn.govt.nz (Not Verified[10.50.0.103]) by mail.selwyn.govt.nz with MailMarshal (v7,2,3,6978)
    id <B59ff91800000>; Mon, 06 Nov 2017 11:32:32 +1300
Received: from SDCEX2013.sdc.selwyn.local (10.50.0.9) by
    SDCEX2013.sdc.selwyn.local (10.50.0.9) with Microsoft SMTP Server (TLS) id
    15.0.1320.4; Mon, 6 Nov 2017 11:32:32 +1300
Received: from SDCEX2013.sdc.selwyn.local ([::1]) by
    SDCEX2013.sdc.selwyn.local ([fe80::e48d:2473:b931:e3a%12]) with Microsoft
    SMTP Server id 15.00.1320.000; Mon, 6 Nov 2017 11:32:32 +1300
From: BCA <buildingadmin_designdocument@selwyn.govt.nz>
To: AlphaOne Support <support@abcs.co.nz>
Subject: Selwyn Autoreply
Thread-Topic: Selwyn Autoreply
Thread-Index: AQHTVoX48qQf/rL9R02Db7+QqglAPw==
Date: Sun, 5 Nov 2017 22:32:32 +0000
Message-ID: <b5d66930e76243eb8bddd885ad3fafdd@SDCEX2013.sdc.selwyn.local>
X-MS-Has-Attach:
x-autoreply: yes
X-MS-Exchange-Inbox-Rules-Loop: buildingadmin_designdocument@selwyn.govt.nz
X-MS-TNEF-Correlator:
x-ms-exchange-transport-fromentityheader: Hosted
x-ms-exchange-parent-message-id: <7895a7aa177b6668da30d8332fd365b6@abcs.co.nz>
auto-submitted: auto-generated
x-ms-exchange-generated-message-source: Mailbox Rules Agent
Content-Type: text/plain; charset="us-ascii"
Content-Transfer-Encoding: quoted-printable
MIME-Version: 1.0
EOF;
        return $headers;
    }
}