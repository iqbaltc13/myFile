<?php

namespace App\Models;

use RuntimeException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;

class CustomEncrypter implements EncrypterContract
{
    /**
     * The encryption key.
     *
     * @var string
     */
    protected $key;

    /**
     * The algorithm used for encryption.
     *
     * @var string
     */
    protected $cipher;

    /**
     * Create a new encrypter instance.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return void
     *
     * @throws \RuntimeException
     */
    public function __construct($key, $cipher = 'AES-128-CBC')
    {
        $key = (string) $key;

        if (static::supported($key, $cipher)) {
            $this->key = $key;
            $this->cipher = $cipher;
        } else {
            throw new RuntimeException('The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths.');
        }
    }

    /**
     * Determine if the given key and cipher combination is valid.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return bool
     */
    public static function supported($key, $cipher)
    {
        $length = mb_strlen($key, '8bit');

        return ($cipher === 'AES-128-CBC' && $length === 16) || ($cipher === 'AES-256-CBC' && $length === 32);
    }

    public function encrypt($value, $serialize = true)
    {
        // $bytes = random_bytes(16);
        $iv = $this->generateRandomString();
        // $iv = 1234567890123456;

        $encrypted = \openssl_encrypt($value, $this->cipher, $this->key, 0, $iv);
        $AES = $encrypted;

        if ($encrypted === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        $encrypted = base64_encode($encrypted);
        $encrypted = $iv.$encrypted;

        return $encrypted;
    }

    public function decrypt($value, $serialize = true)
    {
        $input = $value;

        $valueLength = strlen($value);

        $iv = substr($value, 0, 16);

        $contentLength = $valueLength - 16;

        $value = substr($value, 16, $contentLength);

        $value = base64_decode($value);

        $decrypted = \openssl_decrypt($value, $this->cipher, $this->key, 0, $iv);

        if ($decrypted === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return $decrypted;
    }

    public function generateRandomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}