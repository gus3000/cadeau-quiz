<?php

use App\Models\Answer;
use App\Models\Guess;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guesses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Answer::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->integer('score');

            $table->unique(['user_id', 'answer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guesses');
    }
};
