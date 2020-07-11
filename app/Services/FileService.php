<?php

namespace App\Services;

use App\Models\Download;
use App\Models\File;

class FileService
{

    /**
     * @param File $file
     * @return bool
     */
    public function download(File $file): bool
    {
        $model = new Download();
        $model->fileId = $file->getKey();
        $model->ip = request()->ip();
        $model->parameters = json_encode([
            'userAgent' => request()->headers->get('User-Agent'),
            'language' => request()->getPreferredLanguage(),
            'referer' => request()->headers->get('referer')
        ], JSON_THROW_ON_ERROR);
        $model->date = time();
        $model->createdAt = time();

        return $model->save();
    }

    /**
     * @param File $file
     * @return string
     */
    public function icon(File $file): string
    {
        switch ($file->type) {
            // archive
            case 'zip':
                return 'fa-file-archive';

            case 'rar':
            case 'tar':
            case 'tgz':
            case 'gz':
                return 'fa-archive';

            // docs
            case 'pdf':
                return 'fa-file-pdf';

            case 'tiff':
                return 'fa-file-image';

            // word
            case 'doc':
            case 'docx':
            case 'rdf':
                return 'fa-file-word';

            // excel
            case 'xlsx':
            case 'xlsm':
            case 'xlsb':
            case 'xltx':
            case 'xltm':
            case 'xls':
            case 'xlt':
            case 'rtf':
                return 'fa-file-excel-o';

            // text
            case 'csv':
                return 'fa-file-text';
        }

        return 'fa-file';
    }

}
