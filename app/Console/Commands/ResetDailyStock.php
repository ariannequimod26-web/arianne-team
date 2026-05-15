<?php

namespace App\Console\Commands;

use App\Models\MenuItem;
use Illuminate\Console\Command;

class ResetDailyStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:reset-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the sold_today count for all menu items to zero.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        MenuItem::query()->update(['sold_today' => 0]);
        
        $this->info('Daily stock counts have been reset successfully!');
    }
}
