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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call("migrate:fresh");
        $this->call("app:seed");
        $this->call("ide-helper:models", ["--write" => true]);
    }
}
