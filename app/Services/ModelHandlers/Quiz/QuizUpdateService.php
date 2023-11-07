<?php

namespace App\Services\ModelHandlers\Quiz;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\ModelHandlers\Question\QuestionCreateService;
use App\Services\ModelHandlers\Question\QuestionUpdateService;
use App\Services\ModelHandlers\UpdateService;

class QuizUpdateService extends UpdateService
{

    public function __construct(
        protected QuestionUpdateService $questionUpdateService,
        protected QuestionCreateService $questionCreateService,
    )
    {
        parent::__construct(Quiz::class);
    }

    public function updateQuiz(Quiz $quiz, array $attributes, bool $includeQuestions = true, bool $includeAnswers = true): void
    {
        $this->update($quiz, $attributes);

        if(!$includeQuestions)
            return;

        foreach($this->getRelationToUpdate($quiz, Question::class, $attributes['questions']) as [$question, $questionAttributes]) {
            $this->questionUpdateService->updateQuestion($question, $questionAttributes, $includeAnswers);
        }
    }
}
