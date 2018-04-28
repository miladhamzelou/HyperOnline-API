<?php
/**
 * Copyright (c) 2018 - All Rights Reserved - Arash Hatami
 */

/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/27/18
 * Time: 12:06 PM
 */

namespace App\Libraries;


use RNCryptor\RNCryptor\Decryptor;

class EncryptionHelper
{
    private $key;


    function __construct()
    {
        $this->key = config('app.custom_key');
    }

    function getJSON($encrypted)
    {
        $crypt = new Decryptor();
        $decrypted = $crypt->decrypt($encrypted, $this->key);
        return json_decode($decrypted, true);
    }
}