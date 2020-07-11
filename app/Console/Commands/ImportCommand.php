<?php

namespace App\Console\Commands;

use App\Models\Download;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import old data';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(): void
    {
        $query = DB::query()->from('downloads')->orderBy('id');
        $progressBar = $this->output->createProgressBar($query->count());
        $query->each(static function ($datum) use ($progressBar) {
            $model = new Download();
            $model->fill([
                'fileId' => $datum->file_id,
                'ip' => $datum->ip,
                'parameters' => $datum->parameters,
                'date' => $datum->created_at,
                'createdAt' => $datum->created_at,
            ]);
            $progressBar->advance();
            $model->save();
        }, 250);

        $progressBar->finish();
    }

}
