<?php

namespace App\Console\Commands;

use Database\Seeders\GuessSeeder;
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
    protected $description = 'Executes all available seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ([
                     UserSeeder::class,
                     QuizSeeder::class,
                     GuessSeeder::class,
                 ] as $seederClass) {
            $this->info("Seeding from {$seederClass}");
            $this->callSilently('db:seed', ['--class' => $seederClass, '--no-interaction' => true]);
        }

    }
}
