<?php

namespace App\Console\Commands;

use App\Models\Timetable;
use App\Services\GeneticAlgorithm\TimetableGA;

use Illuminate\Console\Command;
use App\Jobs\GenerateTimetable;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
        //$this->timetable = Timetable::create([
        //  'name' => 'Automatic', 'user_id' => 1]);
        //$this->timetable->days()->sync([1,2,3,4,5]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Generating timetable');
        $timetable = Timetable::where('status', 'IN PROGRESS')->latest()->first();

        if ($timetable) {
            $timetableGA = new TimetableGA($timetable);
            $timetableGA->run();
            Log::info('Timetable Generated');
        } else {
            Log::info('No timetable with status "IN PROGRESS" found.');
        }
        //dispatch(new GenerateTimetable());
    }
}
