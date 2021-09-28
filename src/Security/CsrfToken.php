<?php


namespace camilord\utilus\Security;

use camilord\utilus\Algorithm\UUID;
use camilord\utilus\Data\ArrayUtilus;
use camilord\utilus\Encryption\DataCrypt7x;
use camilord\utilus\Encryption\DataCryptInterface;

/**
 * Class CsrfToken
 * @package camilord\utilus\Security
 */
class CsrfToken
{
    private $expiration;
    private $key;
    private $secret_key;

    const PREFIX = '_csrf_sessions';

    /**
     * @var DataCryptInterface
     */
    private $encoder;

    /**
     * @var string|null
     */
    private $error_message = null;

    /**
     * CsrfToken constructor.
     * @param int $expiration
     * @param string|null $key
     * @param string|null $secret_key
     */
    public function __construct(int $expiration = 3600, ?string $key = null, ?string $secret_key = null) {
        $this->expiration = $expiration;
        $this->key = $key;
        $this->secret_key = $secret_key;

        if (!$this->expiration) {
            $this->expiration = 1500;
        }

        /**
         * @reference: https://www.php.net/manual/en/function.session-status.php
         */
        if (php_sapi_name() !== 'cli' && session_status() !== 2) {
            session_start();
        }

        if (!isset($_SESSION[self::PREFIX])) {
            $_SESSION[self::PREFIX] = [];
        }

        $this->clean_csrf();
    }

    /**
     * @param string $identify
     * @return string
     */
    public function generate(string $identify): string
    {
        $csrf_token_data = [
            'uuid' => UUID::v4(),
            'expire' => (time() + $this->expiration),
            'hash' => sha1(time())
        ];

        if (!isset($_SESSION[self::PREFIX][$identify])) {
            $_SESSION[self::PREFIX][$identify] = [];
        }

        $csrf_token = $this->getEncoder()->encode(json_encode($csrf_token_data, JSON_PRETTY_PRINT));
        $hash_token = sha1($csrf_token);
        $_SESSION[self::PREFIX][$identify][$hash_token] = $csrf_token;

        return $_SESSION[self::PREFIX][$identify][$hash_token];
    }

    /**
     * @param string $identify
     * @param string $submitted_token
     * @return bool
     */
    public function is_csrf_valid(string $identify, string $submitted_token): bool
    {
        $server_token = [];
        $hash_token = sha1($submitted_token);
        if (isset($_SESSION[self::PREFIX][$identify][$hash_token])) {
            $csrf_token = $_SESSION[self::PREFIX][$identify][$hash_token];
            $server_token = json_decode($this->getEncoder()->decode($csrf_token), true);
        }

        $submitted_data = json_decode($this->getEncoder()->decode($submitted_token), true);
        $this->setErrorMessage('Error! CSRF token mismatch.');

        if (ArrayUtilus::haveData($submitted_data) && ArrayUtilus::haveData($server_token)) {
            if (
                isset($server_token['uuid']) && isset($submitted_data['uuid']) &&
                isset($server_token['hash']) && isset($submitted_data['hash']) &&
                $server_token['uuid'] === $submitted_data['uuid'] &&
                $server_token['hash'] === $submitted_data['hash'] &&
                (int)$submitted_data['expire'] >= time()
            ) {
                $this->destroy($identify, $submitted_token);
                $this->setErrorMessage(null);
                return true;
            }

            if ($submitted_data['expire'] < time()) {
                $this->setErrorMessage('Error! CSRF token has been expired');
            }
        }

        return false;
    }

    /**
     * @param string $identify
     * @param string $csrf_token
     */
    public function destroy(string $identify, string $csrf_token) {
        $hash_token = sha1($csrf_token);
        unset($_SESSION[self::PREFIX][$identify][$hash_token]);
        $this->clean_csrf();
    }

    /**
     * destroy all csrf tokens
     */
    public function destroy_all() {
        if (isset($_SESSION[self::PREFIX]) && ArrayUtilus::haveData($_SESSION[self::PREFIX])) {
            $_SESSION[self::PREFIX] = [];
        }
    }

    /**
     * @return DataCryptInterface
     */
    private function getEncoder()
    {
        if (!$this->encoder) {
            $this->encoder = new DataCrypt7x();
            if ($this->key) {
                $this->encoder->iv_key = $this->key;
            }
            if ($this->secret_key) {
                $this->encoder->secret_key = $this->secret_key;
            }
        }

        return $this->encoder;
    }

    /**
     * clean up method for the sessions
     */
    private function clean_csrf()
    {
        if (ArrayUtilus::haveData($_SESSION[self::PREFIX]))
        {
            // delete expired csrf tokens
            foreach($_SESSION[self::PREFIX] as $identify => $sessions) {
                foreach($sessions as $hash_token => $csrf_token) {
                    $csrf_data = json_decode($this->getEncoder()->decode($csrf_token), true);

                    if (isset($csrf_data['expire']) && (int)$csrf_data['expire'] < time()) {
                        unset($sessions[$hash_token]);
                    }
                }

                // if there's too many records, deleted the old ones
                if (ArrayUtilus::haveData($sessions)) {
                    while(count($sessions) > 50) {
                        array_shift($sessions);
                    }
                }

                $_SESSION[self::PREFIX][$identify] = $sessions;

                // if the area is empty array, delete the area
                if (!ArrayUtilus::haveData($_SESSION[self::PREFIX][$identify])) {
                    unset($_SESSION[self::PREFIX][$identify]);
                }
            }
        }
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->error_message;
    }

    /**
     * @param string|null $error_message
     */
    public function setErrorMessage(?string $error_message): void
    {
        $this->error_message = $error_message;
    }
}