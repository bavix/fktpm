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
        $downloads = Download::with('file')
            ->select('file_id', DB::raw('sum(1) res'))
            ->groupBy('file_id')
            ->where('created_at', '>', $month->toDateTimeString())
            ->where('parameters', 'not like', '%bot%')
            ->orderBy('res');

        /**
         * @var Download $download
         */
        foreach ($downloads->get() as $key => $download) {
            if (!$download->file) {
                continue;
            }

            $download->file->update(['sort' => $key + 1]);
        }
    }

}
