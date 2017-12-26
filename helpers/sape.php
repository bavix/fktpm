<?php

if (!defined('_SAPE_USER')){
    define('_SAPE_USER', 'afe4ffefe1832be3847f82a6a2363822');
}

include_once dirname(__DIR__) . '/public/' . _SAPE_USER . '/sape.php';

function sape(): SAPE_client
{
    static $client;

    if (!$client)
    {
        $client = new SAPE_client();
    }

    return $client;
}
