<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ExportController;

class schedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create your 3 months clening office schedule in CSV';

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
        ExportController::exportFile();
        $this->info('Your schedule is exported in storage/app/schedule');
    }
}
    
