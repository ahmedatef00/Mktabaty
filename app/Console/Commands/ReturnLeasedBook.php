<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class ReturnLeasedBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'return-book';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'return book back automatically';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $rows = DB::table('book_lease')->where('return_at', '<=', Carbon::now())->get();
            DB::table('book_lease')->where('return_at', '<=', Carbon::now())->update(array('deleted_at' => DB::raw('NOW()')));

            foreach ($rows as $row) {
                DB::table('books')->where('id', $row->book_id)->increment('available');
            }

            DB::commit();
        } catch (\Illuminate\Database\QueryException $ex) {
            echo $ex;
        }
    }
}
