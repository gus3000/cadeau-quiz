<?php

namespace App\Console\Commands;

use App\Models\Quiz;
use Illuminate\Console\Command;

class DebugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug';

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
        $question = Quiz::currentlyOpen()->current_question;
        dump($question->time_remaining_with_grace_period);
    }
}
