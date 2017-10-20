<?php

namespace App\Helpers;

use Bavix\Helpers\Str;

trait ModelUrl
{

    public function url()
    {
        return route($this->route, [
            'id'    => $this->id,
            'title' => Str::friendlyUrl($this->title)
        ]);
    }

}
