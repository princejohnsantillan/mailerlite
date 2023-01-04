<?php

namespace App\Models;

use App\Models\Enums\FieldType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Field extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => FieldType::class,
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class)->withPivot('value');
    }
}
