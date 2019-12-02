<?php

namespace App\Services;

if (!defined('_SAPE_USER')) {
    define('_SAPE_USER', env('SAPE_KEY', 'SAPE'));
}

class SapeService
{

    /**
     * @var \SAPE_client
     */
    protected $client;

    /**
     * SapeService constructor.
     */
    public function __construct()
    {
        if (class_exists(\SAPE_client::class, false)) {
            return;
        }

        if (file_exists(dirname(__DIR__) . '/public/' . _SAPE_USER . '/sape.php')) {
            include_once dirname(__DIR__) . '/public/' . _SAPE_USER . '/sape.php';
        }
    }

    /**
     * @return \SAPE_client|null
     */
    public function client()
    {
        if (!$this->client && class_exists(\SAPE_client::class, false)) {
            $options = ['charset' => 'utf-8'];

            if (env('SAPE_FORCE_SHOW_CODE')) {
                $options['force_show_code'] = true;
            }

            $this->client = new \SAPE_client($options);
        }

        return $this->client;
    }

}
