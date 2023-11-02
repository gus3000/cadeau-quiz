<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::whereEmail('gus3000spam@gmail.com')->first();

        $quiz = Quiz::factory()->create([
            'name' => 'Ennemis de JV (beta)',
            'short_name' => 'ennemis_jv',
            'created_by' => $user->id,
            'opened_at' => new \DateTime(),
            'finished' => true,
        ]);

        $this->importCsv($quiz);

        $quiz = Quiz::factory()->create([
            'name' => 'Ennemis de JV',
            'short_name' => 'ennemis_jv',
            'created_by' => $user->id,
            'opened_at' => new \DateTime(),
            'finished' => false,
        ]);

        $this->importCsv($quiz);
//        $quiz->current_question = Question::whereQuizId($quiz->id)->orderBy('order')->first()->id;
        $quiz->save();
    }

    private function importCsv(Quiz $quiz): void
    {
        $shortName = $quiz->short_name;
        $csv = array_map("str_getcsv", file("database/data/questions/$shortName.csv", FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        foreach ($csv as $index => $row) {
            $questionData = array_combine($keys, $row);
            $questionData['quiz_id'] = $quiz->id;
//            $questionData['open'] = false;
            $questionData['order'] = $index;

            $correct_answer = $questionData['answer'];
            $answers = [
                $questionData['answer']
            ];
            unset($questionData['answer']);
            for ($i = 1; $i <= 3; $i++) {
                $answers[] = $questionData['false_proposition' . $i];
                unset($questionData['false_proposition' . $i]);
            }
            $question = Question::create($questionData);

            $orders = range(1, count($answers));
            shuffle($orders);

            foreach ($answers as $i => $answer) {
                Answer::create([
                    'question_id' => $question->id,
                    'text' => $answer,
                    'correct' => $answer === $correct_answer,
                    'order' => $orders[$i],
                ]);
            }
        }
    }
}
