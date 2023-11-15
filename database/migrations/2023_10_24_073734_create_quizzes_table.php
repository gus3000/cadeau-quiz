<?php

use App\Models\Question;
use App\Models\Quiz;
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
        Schema::create('quizzes', function(Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('opened_at')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->constrained('users');
            $table->string('name');
            $table->string('short_name');
            $table->string('logo_url')->nullable();
            $table->integer('default_duration')->default(10);
            $table->integer('default_number_of_answers')->default(4);
            $table->boolean('locked')->default(false);
            $table->boolean('finished')->default(false);
            $table->boolean('closed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
