<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;


/**
 * App\Models\Guess
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $answer_id
 * @property int $user_id
 * @property-read \App\Models\Answer $answer
 * @property-read \App\Models\Question|null $question
 * @method static \Database\Factories\GuessFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Guess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guess query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereUserId($value)
 * @mixin \Eloquent
 */
class Guess extends Model
{
    use HasFactory;


    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    public function question(): HasOneThrough
    {
        return $this->hasOneThrough(Question::class, Answer::class);
    }
}
