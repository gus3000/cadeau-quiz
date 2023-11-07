<?php

namespace App\Services\ModelHandlers\Question;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\ModelHandlers\UpdateService;
use Illuminate\Database\Eloquent\Model;

/**
 * @template-implements UpdateService<Question>
 */
class QuestionUpdateService extends UpdateService
{

    public function __construct(
        protected AnswerUpdateService $answerUpdateService,
    )
    {
        parent::__construct(Question::class);
    }

    public function updateQuestion(Question $question, array $attributes, bool $updateAnswers): void
    {
        $this->update($question, $attributes);

        if (!$updateAnswers)
            return;

        foreach ($this->getRelationToUpdate($question, Answer::class, $attributes['answers']) as [$answer, $answerAttributes]) {
            $this->answerUpdateService->update($answer, $answerAttributes);
        }
    }

}
