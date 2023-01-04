<?php

namespace App\Models;

use App\Models\Enums\SubscriberState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
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
        'state' => SubscriberState::class,
    ];

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class)->withPivot('value');
    }
}
