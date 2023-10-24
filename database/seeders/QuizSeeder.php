<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Question::factory(5)->create();
//        Question::factory()->create([
//            'question_text' => 'this is a question text'
//        ]);

        $quiz = Quiz::factory()->create([
            'name' => 'Ennemis de JV',
            'short_name' => 'ennemis_jv'
        ]);

        $this->importCsv($quiz);
    }

    private function importCsv(Quiz $quiz):void {
        $shortName = $quiz->short_name;
        $csvFile = fopen(base_path("database/data/questions/$shortName.csv"), "r");

        $firstLine = true;
        

        fclose($csvFile);
    }
}
