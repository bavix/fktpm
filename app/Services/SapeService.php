<?php

namespace App\Services;

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
        include_once dirname(__DIR__, 2) . '/helpers/consts.php';
        if (file_exists(dirname(__DIR__) . '/public/' . _SAPE_USER . '/sape.php')) {
            include_once dirname(__DIR__) . '/public/' . _SAPE_USER . '/sape.php';
        }
    }

    /**
     * @return \SAPE_client|null
     */
    public function client()
    {
        if (!$this->client && class_exists(\SAPE_client::class)) {
            $options = ['charset' => 'utf-8'];

            if (config('sape.force')) {
                $options['force_show_code'] = true;
            }

            $this->client = new \SAPE_client($options);
        }

        return $this->client;
    }

}
