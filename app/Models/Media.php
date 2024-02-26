<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Media
 *
 * @property int $id
 * @property int $question_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $media_type_id
 * @property string $path
 * @property-read mixed $file
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMediaTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'media_type_id',
        'path',
    ];

    protected $appends = [
        'file',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function getFileAttribute()
    {
        return Storage::disk('media')->url($this->path);
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Media $model) {
            Storage::disk('media')->delete($model->path);
        });
    }
}
