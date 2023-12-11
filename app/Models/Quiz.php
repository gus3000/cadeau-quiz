<?php

namespace App\Models;

use App\Events\NextQuestion;
use App\Models\Enum\PlayerStatsType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Quiz
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $opened_at
 * @property int $created_by
 * @property string $name
 * @property string $short_name
 * @property string|null $logo_url
 * @property int $default_duration
 * @property int $default_number_of_answers
 * @property int $locked
 * @property int $finished
 * @property int $closed
 * @property \App\Models\Question|null $current_question
 * @property-read bool $is_open
 * @property-read array $stats
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\QuizFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereDefaultDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereDefaultNumberOfAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereFinished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereOpenedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Quiz withoutTrashed()
 * @mixin \Eloquent
 */
class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'short_name',
        'logo_url',
        'default_duration',
        'default_number_of_answers'
    ];


    const CLIENT_GRACE_PERIOD_SECONDS = 3.0;
    const SERVER_GRACE_PERIOD_SECONDS = 1.0; // on top of client grace period

    public static function currentlyOpen(): ?Quiz
    {
        return self::whereClosed(false)
            ->whereNotNull('opened_at')
            ->orderByDesc('opened_at')
            ->first();
    }

    public function getIsOpenAttribute(): bool
    {
        return $this->opened_at !== null && !$this->closed;
    }

    public function open(): void
    {
        $this->opened_at = \Date::now();
        $this->finished = false;
        $this->closed = false;
        $this->save();
    }

    public function close(): void
    {
        $this->closed = true;
        $this->save();
    }

    public function nextQuestion(): void
    {
        $currentQuestion = $this->current_question;
        if (is_null($currentQuestion) && !$this->finished) {
            $this->current_question = $this->questions->first();
        } else if (!is_null($currentQuestion)) {
            $questions = $this->questions->getIterator();
            foreach ($questions as $question) {
                if ($question->id === $currentQuestion->id)
                    break;
            }

            $questions->next();
            $this->current_question = $questions->current();
        }

        $this->save();

        $currentQuestion = $this->current_question;
        if (!is_null($currentQuestion)) {
            $currentQuestion->opened_at = new \DateTime();
            $currentQuestion->save();
        }

        NextQuestion::dispatch();
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "id", "created_by");
    }

    public function setCurrentQuestionAttribute(?Question $question): void
    {
        if (is_null($question)) {
            $this->finished = true;
            return;
        }

        if ($question->quiz_id !== $this->id)
            throw new \Exception("cannot set current question to question {$question->id} with quiz_id {$question->quiz_id} on quiz {$this->id}");

        $question->opened_at = new \DateTime();
        $question->save();
    }

    public function getCurrentQuestionAttribute(): ?Question
    {
        if ($this->finished)
            return null;
        return
            $this->questions->whereNotNull('opened_at')->last();
    }

    public function getStatsAttribute(): array
    {
        $playerStats = [];
        foreach($this->questions as $question) {
            if(is_null($question->opened_at))
                continue;
            $questionStats = $question->stats;
            foreach($questionStats['players'] as $stat) {
                $name = $stat['name'];
                if(!key_exists($name, $playerStats)) {
                    $playerStats[$name] = [
                        'name' => $name,
                        'score' => 0,
                        'goodAnswers' => 0,
                    ];
                }

                $playerStats[$name]['score'] += $stat['score'];
                if($stat['correct'])
                    $playerStats[$name]['goodAnswers']++;
            }
        }


        usort($playerStats, fn($a,$b) => $b['score'] <=> $a['score']);

        return [
            'players' => $playerStats,
            'statsType' => 0    ,
        ];
    }
}
