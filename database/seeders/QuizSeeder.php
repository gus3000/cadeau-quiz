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
//            'text' => 'this is a question text'
//        ]);

        $quiz = Quiz::factory()->create([
            'name' => 'Ennemis de JV',
            'short_name' => 'ennemis_jv'
        ]);

        $this->importCsv($quiz);
    }

    private function importCsv(Quiz $quiz): void
    {
        $shortName = $quiz->short_name;
        $csv = array_map("str_getcsv", file("database/data/questions/$shortName.csv",FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        foreach($csv as $i => $row) {
            $question = array_combine($keys,$row);
            $question['quiz_id'] = $quiz->id;
            dump($question);
            Question::create($question);
        }
    }
}
