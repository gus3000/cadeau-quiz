<?php

namespace App\Models;

use App\Events\QuestionClosed;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $opened_at
 * @property int $quiz_id
 * @property string $text
 * @property float $duration
 * @property int $closed
 * @property int $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Answer> $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\Answer $correct_answer
 * @property-read bool $finished
 * @property-read bool $is_open
 * @property-read \App\Models\Media|null $media
 * @property-read \App\Models\Quiz $quiz
 * @method static \Database\Factories\QuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereOpenedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Question withoutTrashed()
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'opened_at' => 'datetime'
    ];

    protected $appends = [
        'correct_answer'
    ];

    public function getIsOpenAttribute(): bool
    {
        return !is_null($this->opened_at);
    }

    public function getFinishedAttribute(): bool
    {
        if (is_null($this->opened_at))
            return false;
        $openedAt = $this->opened_at->timestamp;
        $now = time();

        return ($now - $openedAt) > $this->duration;
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getCorrectAnswerAttribute(): Answer
    {
        return $this->answers
            ->where('correct', '=', true)
            ->first();
    }

    public function setClosedAttribute(bool $closed): void {
        $wasClosed = $this->closed;
        if(!$wasClosed && $closed){
            QuestionClosed::dispatch($this->id);
        }

        $this->attributes['closed'] = $closed;
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class)->orderBy('order');
    }

    public function media(): HasOne
    {
        return $this->hasOne(Media::class);
    }
}
