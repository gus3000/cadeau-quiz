<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizApiController extends Controller
{
    public function lock(Quiz $quiz) {
        $quiz->locked = true;
        $quiz->save();

        return $quiz;
    }

    public function getAllowedUsers(Quiz $quiz) {
        return $quiz->allowedUsers()->get();
    }

    public function setAllowedUsers(Request $request, Quiz $quiz): void {
        $allowedUserIds = $request->get('checkedUsers');
        $quiz->allowedUsers()->sync($allowedUserIds);
    }
}
