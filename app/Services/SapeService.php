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
        if (class_exists(\SAPE_client::class, false)) {
            return;
        }

        include_once dirname(__DIR__, 2) . '/helpers/consts.php';
        if (file_exists(dirname(__DIR__) . '/public/' . env('SAPE_KEY') . '/sape.php')) {
            include_once dirname(__DIR__) . '/public/' . env('SAPE_KEY') . '/sape.php';
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
