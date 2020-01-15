<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegisterTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astral:register-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Registers Astral's scheduled tasks with the operating system";

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
        $OS = explode(" ", php_uname('s'))[0];

        $path = base_path();

        if ($OS == 'Windows') {
          // Delete previous entries
          shell_exec('SCHTASKS /DELETE /TN "Astral" /f');
          // Add new entry
          shell_exec('SCHTASKS /CREATE /SC MINUTE /MO 1 /TN "Astral" /TR ' . "php $path\artisan schedule:run");
        } else if ($OS == 'Linux') {
          shell_exec('(crontab -l ; echo "* * * * * ' . "php $path/artisan schedule:run" . ' >> /dev/null 2>&1") | sort - | uniq - | crontab -');
        }

        $this->info("Succesfully created task scheduling!");
    }
}
