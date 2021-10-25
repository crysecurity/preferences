<?php

namespace Cr4sec\Preferences\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @package Cr4sec\Prefernces\Models
 *
 * @property-read int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string $key
 * @property string|null $key_type
 * @property string|null $value
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Preference extends Model
{
    protected $table = 'preferences';

    protected $casts = ['model_id' => 'int'];

    protected $fillable = [
        'key',
        'key_type',
        'value'
    ];

    protected $touches = ['model'];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
