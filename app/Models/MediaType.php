<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MediaType
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $short_name
 * @property string|null $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MediaType extends Model
{
    use HasFactory;
}
