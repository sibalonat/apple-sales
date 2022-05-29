<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UpdateRankingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rankings';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vendors = User::vendors()->get();

        $bar = $this->output->createProgressBar($vendors->count());

        $bar->start();

        $vendors->each(function(User $user) use($bar) {
            Redis::zadd('rankings', (int)$user->revenue, $user->name);

            $bar->advance();
        });

        $bar->finish();

    }
}
