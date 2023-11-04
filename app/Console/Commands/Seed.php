<?php

namespace App\Console\Commands;

use App\Models\MediaType;
use Database\Seeders\GuessSeeder;
use Database\Seeders\MediaTypeSeeder;
use Database\Seeders\QuizSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class Seed extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed {--force}';


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
        if (! $this->confirmToProceed()) {
            return 1;
        }

        foreach ([
                     UserSeeder::class,
                     MediaTypeSeeder::class,
                     QuizSeeder::class,
                     GuessSeeder::class,
                 ] as $seederClass) {
            $this->info("Seeding from {$seederClass}");
            $this->callSilently('db:seed', ['--class' => $seederClass, '--force' => true]);
        }

    }
}
