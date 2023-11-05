<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuizController extends Controller
{

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
//        $b = $request->get();
        $validated = $request->validate([
            'test' => 'required'
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
        $user = Auth::user();
        if (!$user->admin && !$user->id === $quiz->created_by)
            abort(403, "Vous n'êtes pas autorisé à modifier ce quiz");

        $quiz->load('questions.answers');

        return Inertia::render('Dashboard/QuizEdit', [
            'quiz' => $quiz
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
