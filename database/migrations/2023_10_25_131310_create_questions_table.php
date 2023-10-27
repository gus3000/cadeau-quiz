<?php

use App\Models\Quiz;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(Quiz::class)->constrained();
            $table->string('text');
//            $table->string('answer');
//            $table->string('false_proposition1');
//            $table->string('false_proposition2');
//            $table->string('false_proposition3');
            $table->boolean('finished')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
