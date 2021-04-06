<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanUpCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleaning old images, files';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(): void
    {
        /**
         * @var Post[] $posts
         */
        $posts = Post::with(['image', 'images'])
            ->where('active', 0)
            ->cursor();

        $storage = Storage::disk('public');
        foreach ($posts as $post) {
            if ($post->image && $storage->exists($post->image->path)) {
                $storage->delete($post->image->path);
                $post->image->delete();
            }

            /**
             * @var Image $image
             */
            $ids = [];
            foreach ($post->images as $image) {
                if ($storage->exists($image->path)) {
                    $storage->delete($image->path);
                    $ids[] = $image->id;
                }
            }

            if (!empty($ids)) {
                $post->images()->detach($ids);
            }

            $post->delete();
        }
    }

}
