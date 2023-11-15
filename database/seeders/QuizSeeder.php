<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::whereName('castless')->first();
        $unprivilegedUser = User::whereName('cadeauJeff')->first();

        $quizzes = [];
        $quizzes[] = Quiz::factory()->create([
            'name' => 'Ennemis de JV',
            'created_by' => $adminUser->id,
            'opened_at' => new \DateTime('yesterday'),
            'locked' => true,
            'finished' => true,
            'closed' => true,
        ]);

        $quizzes[] = Quiz::factory()->create([
            'name' => 'Culture informatique',
            'created_by' => $adminUser->id,
            'opened_at' => null,
            'locked' => true,
            'finished' => false,
        ]);

        $quizzes[] = Quiz::factory()->create([
            'name' => 'Un quiz sur les patates',
            'created_by' => $unprivilegedUser->id,
            'opened_at' => null,
            'locked' => true,
            'finished' => false,
        ]);

        foreach ($quizzes as $quiz) {
            $this->importCsv($quiz);
            $quiz->save();
        }

    }

    private function importCsv(Quiz $quiz): void
    {
        $name = $quiz->name;
        $csv = array_map("str_getcsv", file("database/data/questions/$name.csv", FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        foreach ($csv as $index => $row) {
            $questionData = array_combine($keys, $row);
            $questionData['quiz_id'] = $quiz->id;
            $questionData['closed'] = $quiz->finished;
            $questionData['order'] = $index + 1;

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
