<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Showing;
use Carbon\Carbon;

class DeactivateExpiredShowings extends Command
{
    protected $signature = 'showings:deactivate-expired';
    protected $description = 'Deactivate showings where to_date is less than today';

    public function handle()
    {
        $today = Carbon::today();

        $expiredShowings = Showing::where('to_date', '<', $today)
                                   ->where('active', 1)
                                   ->update(['active' => 0]);

        $this->info('Expired showings have been deactivated successfully.');
    }
}
