<?php

namespace App\Admin\Extensions;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class MultipleFile extends \Encore\Admin\Form\Field\MultipleFile
{

    /**
     * Prepare for each file.
     *
     * @param UploadedFile $file
     *
     * @return mixed|string
     */
    protected function prepareForeach(UploadedFile $file = null)
    {
        $self = clone $this;
        $self->name = $self->getStoreName($file);

        return tap($self->upload($file), function () use ($self) {
            $self->name = null;
        });
    }

}
