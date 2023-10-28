<?php

namespace App\Console\Commands;

use App\Events\NextQuestion;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Console\Command;

class CloseQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-question {question?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks a question as closed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $questionArgs = $this->argument('question');
        if(empty($questionArgs)) {
            $this->info('No question id given, closing current question...');
            $quiz = Quiz::currentlyOpen();
            $currentQuestion = $quiz->current_question;
            $this->info("Chose question {$currentQuestion->id} from quiz {$quiz->id}");
            $currentQuestion->finished = true;
            $currentQuestion->save();

            NextQuestion::dispatch($quiz->current_question);
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
