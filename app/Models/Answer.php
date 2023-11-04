<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Answer
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $question_id
 * @property string $text
 * @property int $correct
 * @property int $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guess> $guesses
 * @property-read int|null $guesses_count
 * @property-read \App\Models\Question $question
 * @method static \Database\Factories\AnswerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Answer extends Model
{
    use HasFactory;

    protected $hidden = [
        'correct'
    ];

    public function question(): BelongsTo {
        return $this->belongsTo(Question::class);
    }

    public function guesses(): HasMany
    {
        return $this->hasMany(Guess::class);
    }
}
