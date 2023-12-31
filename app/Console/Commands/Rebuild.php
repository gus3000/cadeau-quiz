<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Rebuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erases the database and reloads everything from the migrations and seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call("migrate:fresh");
        $this->call("app:seed", ['--force' => true]);
        if(!\App::isProduction())
            $this->call("ide-helper:models", ["--write" => true, "--smart-reset" => true]);
    }
}
