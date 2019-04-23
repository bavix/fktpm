<?php

namespace App\Console\Commands;

use App\Models\Image;
use Bavix\Commands\WorkerCommand;
use Bavix\Extra\Gearman;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageOptimizeCommand extends WorkerCommand
{

    const PROP_OPTIMIZE_IMAGE = 'optimize-image';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:image-optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Easily optimize images using PHP';

    public function __construct()
    {
        try {
            parent::__construct();
        } catch (\Throwable $throwable) {
            // todo
        }

        $this->map = [
            self::PROP_OPTIMIZE_IMAGE => [$this, 'optimize']
        ];
    }

    public function optimize(\GearmanJob $job)
    {
        /**
         * @var $model Image
         */
        $model = \unserialize($job->workload(), []);

        $ref = new \ReflectionClass(Image::class);
        $prop = $ref->getProperty('sizes');
        $prop->setAccessible(true);

        /**
         * @var array $sizes
         */
        $sizes = $prop->getValue($model);

        $this->warn('Optimize image #' . $model->id);

        foreach ($sizes as $size => $value) {
            $this->info('Optimize image #' . $model->id .
                '; thumbnail: ' . $size);

            $model->$size();
            OptimizerChainFactory::create()
                ->optimize(
                    $model->storage()->path(
                        $model->thumbnailPath($size)
                    )
                );
        }
    }

}
