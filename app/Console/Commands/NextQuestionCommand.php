<?php

namespace App\Console\Commands;

use App\Events\NextQuestion;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Console\Command;

class NextQuestionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:next-question';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Goes to the following question';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Going to the next question !');
        $quiz = Quiz::currentlyOpen();
        $quiz->nextQuestion();
        NextQuestion::dispatch($quiz);

    }
}
