<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task\TodoList;
use Carbon\Carbon;

class deleteTodoList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todolist:emptytrash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty the trash';

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
        $todolists = TodoList::where('status', 0)->where('updated_at', '<=', Carbon::now()->subDay())->get();

        foreach ($todolists as $todolist) {
            $todolist->update([
                'status' => -1
            ]);
        }

        $this->info('Empty trash done!');
    }
}
