<?php

namespace App\Models;

use App\Events\QuestionClosed;
use App\Models\Enum\PlayerStatsType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
 * @property int $duration
 * @property int $closed
 * @property int $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Answer> $answers
 * @property-read int|null $answers_count
 * @property-read \Carbon\Carbon|null $closed_at
 * @property-read \App\Models\Answer|null $correct_answer
 * @property-read bool $finished
 * @property-read bool $is_open
 * @property-read array $stats
 * @property-read float|null $time_remaining
 * @property-read float|null $time_remaining_with_grace_period
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guess> $guesses
 * @property-read int|null $guesses_count
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

    protected $fillable = [
        'quiz_id',
        'text',
        'duration',
        'order',
    ];

    protected $casts = [
        'opened_at' => 'datetime'
    ];

    protected $appends = [
        'correct_answer',
        'time_remaining_with_grace_period'
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

    public function getClosedAtAttribute(): ?Carbon
    {
        if (!$this->closed)
            return null;

        $openedTime = $this->opened_at;
        $openedTime->addSeconds($this->duration);
        return $openedTime;
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getCorrectAnswerAttribute(): ?Answer
    {
        return $this->answers
            ->where('correct', '=', true)
            ->first();
    }

    public function setClosedAttribute(bool $closed): void
    {
        $wasClosed = $this->closed;
        if (!$wasClosed && $closed && $this->id) {
            QuestionClosed::dispatch($this->id);
        }

        $this->attributes['closed'] = $closed;
    }

    public function getTimeRemainingAttribute(): float|null
    {
        if (is_null($this->opened_at))
            return null;

        $now = Carbon::now();
        $delta = $now->floatDiffInSeconds($this->opened_at, false);

        return max(0, $delta + $this->duration);
    }

    public function getTimeRemainingWithGracePeriodAttribute(): float|null
    {
        if (is_null($this->opened_at))
            return null;

        $now = Carbon::now();
        $delta = $now->floatDiffInSeconds($this->opened_at, false);
        $remaining = $delta + $this->duration;

        $cappedRemaining = min($this->duration, $remaining + Quiz::CLIENT_GRACE_PERIOD_SECONDS);
        return max(0, $cappedRemaining);
    }

    public function getDurationAttribute(): int
    {
        if (!is_null($this->attributes['duration']))
            return $this->attributes['duration'];
        return $this->quiz->default_duration;
    }

    public function guessFromUser(User $user): ?Guess
    {
        $answerIds = $this->answers->map(fn($answer) => $answer->id);

        return Guess::whereUserId($user->id)
            ->whereIn('answer_id', $answerIds)
            ->first();
    }

    public function guesses(): HasManyThrough
    {
        return $this->hasManyThrough(Guess::class, Answer::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class)->orderBy('order');
    }

    public function media(): HasOne
    {
        return $this->hasOne(Media::class);
    }

    public function getStatsAttribute(): array
    {
        $stats = [];
        foreach ($this->guesses as $guess) {
            $name = User::find($guess->user_id)->name;
            $correct = $guess->answer_id === $this->correct_answer->id;
            $stats[$name] = [
                'name' => $name,
                'score' => abs($guess->score) * ($correct ? 1 : -1),
                'correct' => $correct,
            ];
        }

        usort($stats, fn($a, $b) => $b['score'] <=> $a['score']);
        return
            [
                'players' => $stats,
                'statsType' => PlayerStatsType::Question,
            ];
    }

//    public function createdBy(): BelongsTo
//    {
//        return $this->hasOneThrough(User::class, Quiz::class, 'created_by');
//    }
}
