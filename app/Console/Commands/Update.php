<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astral:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates Astral's files from version control, dependencies and database";

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
        // Pull the latest updates from git
        $this->info('Updating files...');
        $git = new Process(['git', 'pull']);
        $git->run();
        echo $git->getOutput();
        $this->info('Files updated succesfully!');

        // Install composer dependencies
        $this->info('Updating dependencies...');
        $composer = new Process(['composer', 'install']);
        $composer->run();
        echo $composer->getOutput();
        $this->info('Dependencies updated succesfully!');
        // Migrate database so that the tables and columns sync with updates
        $this->info('Updating database...');
        $this->call('migrate');
        $this->info('Database updated succesfully!');
        $this->info('Clearing cache...');
        Artisan::call('cache:clear');
        $this->info('Cache cleared succesfully!');
        $this->info('Astral has been updated succesfully!');
    }
}
