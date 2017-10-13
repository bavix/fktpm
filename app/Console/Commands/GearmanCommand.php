<?php

namespace App\Console\Commands;

use App\Models\Image;
use Bavix\Gearman\Worker;
use Illuminate\Console\Command;
use ImageOptimizer\OptimizerFactory;

class GearmanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:gearman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gearman Image Cropper';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $console = $this;

        $factory   = new OptimizerFactory();
        $optimizer = $factory->get();

        $worker = new Worker();
        $worker->addServer(
            config('gearman.host'),
            config('gearman.port')
        );

        $worker->addFunction('resize', function (\GearmanJob $job) use ($console)
        {
            /**
             * @var Image $model
             */
            $model = unserialize($job->workload(), []);

            $console->info('image #' . $model->id . ' is loaded');

            foreach ($model->resizeList as $item)
            {
                $console->info('processing task:' . $item . '...');
                $model->{$item}();
            }
        });

        $worker->addFunction('optimize', function (\GearmanJob $job) use ($console, $optimizer)
        {

            if (class_exists(OptimizerFactory::class))
            {
                $path = $job->workload();

                $console->info('processing task:optimize ' . $path);
                $optimizer->optimize($path);
            }

        });

        while ($worker->work())
        {
            continue;
        }

        return;
    }

}
