<?php

namespace App\Admin\Extensions;

class Tags extends \Encore\Admin\Form\Field\Tags
{

    public function variables()
    {
        return \array_merge(parent::variables(), [
            'options' => $this->options
        ]);
    }

}
