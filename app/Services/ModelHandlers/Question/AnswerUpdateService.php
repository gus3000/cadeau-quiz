<?php

namespace App\Services\ModelHandlers\Question;

use App\Models\Answer;
use App\Services\ModelHandlers\UpdateService;

class AnswerUpdateService extends UpdateService
{
    public function __construct()
    {
        parent::__construct(Answer::class);
    }
}
