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
    protected $signature = 'app:next-question {question?*}';

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
        $questionArgs = $this->argument('question');
        if(empty($questionArgs)) {
            $this->info('No question id given, choosing current question...');
            $quiz = Quiz::currentlyOpen();
            $quiz->nextQuestion();
            NextQuestion::dispatch($quiz);
            return;
        }
        $questions = Question::find($questionArgs);
        foreach ($questions as $question) {
            $this->info("Marking question {$question->id} as finished");
            $question->finished = true;
            $question->save();
        }

    }
}
