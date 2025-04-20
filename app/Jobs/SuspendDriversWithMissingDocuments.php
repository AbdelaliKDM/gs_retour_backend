<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SuspendDriversWithMissingDocuments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fields;

    /**
     * Create a new job instance.
     *
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $drivers = User::where('role', 'driver')
            ->where('status', '!=', 'suspended')
            ->whereHas('truck', function ($query) {
                $query->where(function ($q) {
                    foreach ($this->fields as $field) {
                        $q->orWhereNull($field);
                    }
                });
            })
            ->get();

        foreach ($drivers as $driver) {
            $driver->updateStatus('suspended','truck');
        }
    }
}
