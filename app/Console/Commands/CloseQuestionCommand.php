<?php

namespace App\Console\Commands;

use App\Events\CloseQuestion;
use App\Events\NextQuestion;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Console\Command;

class CloseQuestionCommand extends Command
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
        if (empty($questionArgs)) {
            $this->info('No question id given, closing current question...');
            $quiz = Quiz::currentlyOpen();
            $currentQuestion = $quiz->current_question;
            if (is_null($currentQuestion)) {
                $this->info("Current quiz has no current question.");
                return;
            }
            $this->info("Chose question {$currentQuestion->id} from quiz {$quiz->id}");
            $currentQuestion->close();

            CloseQuestion::dispatch($currentQuestion);
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
