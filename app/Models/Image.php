<?php

namespace App\Models;

use Bavix\Helpers\Dir;
use Illuminate\Database\Eloquent\Model;
use Bavix\Helpers\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Constraint;

/**
 * App\Models\Image
 *
 * @property int    $id
 * @property string $src
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $path
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image wherePath($value)
 */
class Image extends Model
{

    public $timestamps = false;

    protected $sizes = [
        'sm' => 200,
        //'md' => 700,
    ];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'imaggable');
    }

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function storage()
    {
        return Storage::disk('public');
    }

    public function thumbnailPath($type)
    {
        return preg_replace(
            '~^(image/)~',
            "thumbs/$type/",
            $this->path
        );
    }

    protected function thumbnail($type)
    {
        try {
            $thumbnail = $this->thumbnailPath($type);
            $imagePath = $this->storage()->path($thumbnail);

            if (!File::exists(\Storage::path($imagePath)))
            {
                /**
                 * @var $image \Intervention\Image\Image
                 */
                $image = \Intervention\Image\Facades\Image::make(
                    $this->storage()->path($this->path)
                );

                $image->resize($this->sizes[$type], null, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                });

                Dir::make(\dirname($imagePath));
                $image->save($imagePath);
            }

            return $thumbnail;
        } catch (\Throwable $exception) {
            return $this->path;
        }
    }

    public function md()
    {
        return $this->thumbnail(__FUNCTION__);
    }

    public function sm()
    {
        return $this->thumbnail(__FUNCTION__);
    }

}
