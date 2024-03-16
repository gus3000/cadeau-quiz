<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use Nette\NotImplementedException;

class AnswerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        throw new NotImplementedException(); //TODO
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        throw new NotImplementedException(); //TODO
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        throw new NotImplementedException(); //TODO
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        throw new NotImplementedException(); //TODO
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
    }
}
