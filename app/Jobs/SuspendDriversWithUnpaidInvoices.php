<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SuspendDriversWithUnpaidInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of months after which unpaid invoices lead to suspension
     */
    protected $monthsThreshold;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $drivers = User::where('role', 'driver')
            ->where('status', '!=', 'suspended')
            ->whereHas('invoices', function ($query) {
                $query->whereDoesntHave('payments', function ($q) {
                        $q->where('status', 'paid');
                    });
            })
            ->get();

        foreach ($drivers as $driver) {
            $driver->updateStatus('suspended', 'invoice');
        }
    }
}
