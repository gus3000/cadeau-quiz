<?php

namespace App\Console\Commands;

use Database\Seeders\QuizSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed';


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
        foreach ([QuizSeeder::class, UserSeeder::class] as $seederClass) {
            $this->info("Seeding from {$seederClass}");
            $this->callSilently('db:seed', ['--class' => $seederClass, '--no-interaction' => true]);
        }

    }
}
