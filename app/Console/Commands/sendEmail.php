<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class sendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendEmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $services = Service::where('is_performed', 0)->get();
        $servicesToNotify = [];

        foreach ($services as $service) {
            $date = Carbon::createFromFormat('Y-m-d', $service->perform_date)->format('Y-m-d');
            $now = Carbon::now();

            if ($now->diffInDays($date) <= 0) {
                array_push($servicesToNotify, $service);
            }
            // Log::info($servicesToNotify);
            $details = [
                'services' => $servicesToNotify,
            ];

            Mail::to('mailtester782@gmail.com')->send(new \App\Mail\ServiceNotification($details));
            $servicesToNotify = [];
        }
    }
}
