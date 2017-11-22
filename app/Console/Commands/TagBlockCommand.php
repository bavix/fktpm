<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;

/**
 * Class TagBlockCommand
 *
 * @package App\Console\Commands
 *
 * UPDATE `tags` SET `is_block`=1 WHERE id in (select tag_id from (
 *  select tag_id, count(distinct taggable_id) cnt
 *  from taggables
 *  group by tag_id
 * ) t where t.cnt > 3)
 */
class TagBlockCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bx:tag-block';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'We update the block tags';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::update('UPDATE `tags` SET `is_block`=?', [0]);
        \DB::update(
            'UPDATE `tags` SET `is_block`=? WHERE id in (select tag_id from (' .
            'select tag_id, count(distinct taggable_id) cnt ' .
            'from taggables where taggable_type = ? ' .
            'group by tag_id ' .
            ') t where t.cnt > ?)',
            [1, File::class, 4]
        );
    }

}
