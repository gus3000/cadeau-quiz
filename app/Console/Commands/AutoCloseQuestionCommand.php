<?php

namespace App\Console\Commands;

use App\Events\QuestionClosed;
use App\Jobs\QuestionClosedSender;
use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCloseQuestionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-close-question';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for questions that need closing, closes them, and sends appropriate events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Closing the current question !');
        $this->components->task('closing', function () {
            $question = Quiz::currentlyOpen()->current_question;
            if ($question === null) {
                $this->info('No current question.');
                return;
            }
            if ($question->closed) {
                $this->info('Current question already closed.');
                return;
            }
            $timeToClose = $question->opened_at->addSeconds($question->duration);
            $now = Carbon::now();

            if ($timeToClose > $now) {
                $this->info('Current question is still going');
                return;
            }
            $this->info("Current question should be closed");
            $question->closed = true;
            $question->save();
        });
    }
}
