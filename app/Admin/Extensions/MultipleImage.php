<?php

namespace App\Admin\Extensions;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class MultipleImage extends \Encore\Admin\Form\Field\MultipleImage
{
    /**
     * Prepare for each file.
     *
     * @param UploadedFile $image
     *
     * @return mixed|string
     */
    protected function prepareForeach(UploadedFile $image = null)
    {
        $self       = clone $this;
        $self->name = $self->getStoreName($image);

        $self->callInterventionMethods($image->getRealPath());

        return tap($self->upload($image), function () use ($self) {
            $self->name = null;
        });
    }
}
