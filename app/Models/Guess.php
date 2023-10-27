<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Guess
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $question_id
 * @property int $user_id
 * @method static \Database\Factories\GuessFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Guess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guess query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereUserId($value)
 * @property int $answer_id
 * @method static \Illuminate\Database\Eloquent\Builder|Guess whereAnswerId($value)
 * @mixin \Eloquent
 */
class Guess extends Model
{
    use HasFactory;
}
