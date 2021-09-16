<?php
/**
 * Developer: Camilo Lozano III - www.camilord.com
 *                              - github.com/camilord
 *                              - linkedin.com/in/camilord
 *
 * utilus - GoogleReCaptcha.php
 * Username: Camilo
 * Date: 16/09/2021
 * Time: 12:00 PM
 */

namespace camilord\utilus\Security;

/**
 * Class GoogleReCaptcha
 * @package camilord\utilus\Security
 */
class GoogleReCaptcha
{
    /**
     * @var string
     */
    private $secret_key;

    /**
     * GoogleReCaptcha constructor.
     * @param string $secret_key
     */
    public function __construct(string $secret_key)
    {
        $this->secret_key = $secret_key;
    }

    /**
     * @reference: https://stackoverflow.com/questions/27274157/how-to-validate-google-recaptcha-v3-on-server-side
     *             credit to https://stackoverflow.com/users/1680919/levite
     *
     * @return false|null
     */
    public function isValid()
    {
        try {

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret'   => $this->secret_key,
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            return json_decode($result) ? json_decode($result)->success : false;
        }
        catch (\Exception $e) {
            return null;
        }
    }
}