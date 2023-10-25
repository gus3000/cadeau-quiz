<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $text
 * @method static \Database\Factories\QuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $answer
 * @property string $false_proposition1
 * @property string $false_proposition2
 * @property string $false_proposition3
 * @method static \Illuminate\Database\Eloquent\Builder|Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereFalseProposition1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereFalseProposition2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereFalseProposition3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Question withoutTrashed()
 * @property int $quiz_id
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereText($value)
 * @property-read array $answers
 * @property-read array $answers_in_random_order
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getAnswersAttribute(): array {
        return [
            $this->answer,
            $this->false_proposition1,
            $this->false_proposition2,
            $this->false_proposition3,
        ];
    }

    public function getAnswersInRandomOrderAttribute(): array {
        $answers = $this->answers;
        shuffle($answers);
        return $answers;
    }
}
