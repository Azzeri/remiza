<?php

namespace App\Console\Commands;

use App\Models\FireBrigadeUnit;
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
        $services = Service::with('unitFromItem')->where('is_performed', 0)->get();
        $units = FireBrigadeUnit::all();
        $servicesToNotify = [];

        foreach ($units as $unit) {
            Log::info($unit->name);
            foreach ($services as $service) {
                // Log::info($service);
                if ($service->unitFromItem->fire_brigade_unit_id == $unit->id) {
                    
                    $date = Carbon::createFromFormat('Y-m-d', $service->perform_date)->format('Y-m-d');
                    $now = Carbon::now();

                    if ($now->diffInDays($date) <= 0) {
                        array_push($servicesToNotify, $service);
                    }
                    // Log::info($servicesToNotify);
                    $details = [
                        'services' => $servicesToNotify,
                    ];
                    foreach ($unit->users as $user) {
                        if ($user->privilege_id == 3){
                            Mail::to($user->email)->send(new \App\Mail\ServiceNotification($details));
                            // Log::info('Wysłano do: '.$user->email);
                            // foreach ($servicesToNotify as $s)
                            //     Log::info($s);
                        }

                    }
                    $servicesToNotify = [];
                }
            }
        }
    }
}
