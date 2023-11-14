<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return $user->questions()->get();
    }

    public function create(Request $request)
    {
        $request->validate([
            "created_at" => "date",
            "quiz_id" => "required|exists:quizzes,id",
            "text" => "string",
            "order" => "required|numeric",

        ]);

        $question = Question::create([
            'quiz_id' => $request->get('quiz_id'),
            'order' => $request->get('order'),
            'text' => $request->get('text'),
        ]);

        Answer::create([
            'question_id' => $question->id,
            'order' => 1,
            'correct' => true,
        ]);

        for ($i = 2; $i <= $question->quiz->default_number_of_answers; $i++) {
            Answer::create([
                'question_id' => $question->id,
                'order' => $i,
                'correct' => false,
            ]);
        }

        $question->load('answers');

        $question->answers->each(function(Answer $answer) {
            $answer->makeVisible('correct');
        });

        return $question;
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question): void
    {
        foreach ($question->answers as $answer)
            $answer->delete();
        $question->delete();
    }
}
