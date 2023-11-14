<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class QuizApiController extends Controller
{
    public function lock(Quiz $quiz) {
        $quiz->locked = true;
        $quiz->save();

        return $quiz;
    }
}
