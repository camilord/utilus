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
    private $expiration = 3600;
    private $key;
    private $secret_key;

    const PREFIX = '_csrf_';

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
    }

    /**
     * @param string $identify
     * @return string
     */
    public function generate(string $identify): string
    {
        $csrf_token = [
            'uuid' => UUID::v4(),
            'expire' => (time() + $this->expiration),
            'hash' => sha1(time())
        ];
        $_SESSION[self::PREFIX.$identify] = $this->getEncoder()->encode(json_encode($csrf_token, JSON_PRETTY_PRINT));

        return $_SESSION[self::PREFIX.$identify];
    }

    /**
     * @param string $identify
     * @param string $submitted_token
     * @return bool
     */
    public function is_csrf_valid(string $identify, string $submitted_token): bool
    {
        $server_token = [];
        if (isset($_SESSION[self::PREFIX.$identify])) {
            $server_token = json_decode($this->getEncoder()->decode($_SESSION[self::PREFIX.$identify]), true);
        }
        $submitted_data = json_decode($this->getEncoder()->decode($submitted_token), true);
        $this->setErrorMessage('Error! Invalid or missing CSRF token.');

        if (ArrayUtilus::haveData($submitted_data) && ArrayUtilus::haveData($server_token)) {
            if (
                isset($server_token['uuid']) && isset($submitted_data['uuid']) &&
                isset($server_token['hash']) && isset($submitted_data['hash']) &&
                $server_token['uuid'] === $submitted_data['uuid'] &&
                $server_token['hash'] === $submitted_data['hash'] &&
                $submitted_data['expire'] >= time()
            ) {
                $this->destroy($identify);
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
     */
    public function destroy(string $identify) {
        unset($_SESSION[self::PREFIX.$identify]);
    }

    /**
     * destroy all csrf tokens
     */
    public function destroy_all() {
        if (ArrayUtilus::haveData($_SESSION)) {
            foreach($_SESSION as $key => $val) {
                if (stripos($key, self::PREFIX) !== false) {
                    $this->destroy($_SESSION[$key]);
                }
            }
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