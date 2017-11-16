<?php

namespace App\Console\Commands;

use App\Models\Download;
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
        DB::update('UPDATE files set sort = null');

        $carbon = Carbon::now()
            ->subMonth();

        $downloads = Download::with('file')
            ->select('file_id', DB::raw('sum(1) res'))
            ->groupBy('file_id')
            ->where('created_at', '>', $carbon->toDateTimeString())
            ->where('parameters', 'not like', '%bot%')
            ->orderBy('res');

        foreach ($downloads->get() as $key => $download)
        {
            $file = $download->file;

            if (!$file)
            {
                continue;
            }

            $file->sort = $key + 1;
            $file->save();
        }
    }

}
