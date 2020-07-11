<?php

namespace App\Console\Commands;

use App\Models\Download;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FileSortCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:file-sort';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic sortable files with downloads table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        File::query()->update(['sort' => DB::raw('null')]);

        $month = Carbon::now()->subMonth();
        $downloads = Download::query()
            ->select('fileId', raw('count() res'))
            ->where('createdAt', '>', $month->toDateTimeString())
            ->whereRaw("notLike(parameters, '%bot%')")
            ->groupBy('fileId')
            ->orderBy('res');

        /**
         * @var Download $download
         */
        foreach ($downloads->get() as $key => $download) {
            File::query()->whereKey($download->fileId)
                ->update(['sort' => $key + 1]);
        }
    }

}
