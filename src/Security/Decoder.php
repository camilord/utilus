<?php

namespace camilord\utilus\Security;

class Decoder 
{
    /**
     * Decoding Cloudflare-protected Emails
     * Summary of cfDecodeEmail
     * Author: https://usamaejaz.com/cloudflare-email-decoding/
     * @param mixed $encodedString
     * @return string
     */
    public static function cfDecodeEmail(string $encodedString)
    {
        $k = hexdec(substr($encodedString,0,2));

        for ($i=2,$email='';$i<strlen($encodedString)-1;$i+=2)
        {
          $email.=chr(hexdec(substr($encodedString,$i,2))^$k);
        }

        return $email;
    }      
}