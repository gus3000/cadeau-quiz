<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\ModelHandlers\Quiz\QuizUpdateService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function __construct(
        protected QuizUpdateService $quizUpdateService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $quizzes = Quiz::whereCreatedBy($user->id)->get();
        return Inertia::render('Dashboard/MyQuizzes', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $quiz = Quiz::factory()->create([
            'created_by' => $user->id,
            'name' => '',
        ]);

        return to_route('quizzes.edit', $quiz);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
//        $b = $request->get();
        $validated = $request->validate([
//            'name' => 'required|unique:quizzes'
        ]);


    }

    public function submitted()
    {
        $user = Auth::user();
        $quizzes = Quiz::where([
            'locked' => true,
            'finished' => false,
        ])->whereNot('created_by', $user->id)
            ->get();

        return Inertia::render('Dashboard/SubmittedQuizzes', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $user = Auth::user();
        if (!$user->admin && !$user->id === $quiz->created_by)
            abort(403, "Vous n'êtes pas autorisé à visualiser ce quiz");

        $quiz->load('questions.answers');

        return Inertia::render('Dashboard/QuizView', [
            'quiz' => $quiz
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.answers');
        $quiz->questions->each(function (Question $question) {
            $question->answers->each(function (Answer $answer) {
                $answer->makeVisible('correct');
            });
        });

        return Inertia::render('Dashboard/QuizEdit', [
            'quiz' => $quiz
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $this->quizUpdateService->updateQuiz($quiz, $request->all());
        return $quiz->load('questions.answers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        die('destroy');
    }
}
