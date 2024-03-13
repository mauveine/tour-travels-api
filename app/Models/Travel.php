<?php

namespace App\Models;

use App\Models\Data\TravelMoods;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Travel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'travels';

    protected $appends = [
        'numberOfNights',
    ];

    protected $fillable = [
        'slug',
        'name',
        'description',
        'numberOfDays',
        'moods',
        'public',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'moods' => TravelMoods::class,
        'public' => 'boolean'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getNumberOfNightsAttribute(): int
    {
        return $this->attributes['numberOfNights'] ?? $this->attributes['numberOfDays'] - 1;
    }

    public static function boot(): void
    {
        parent::boot();
        /**
         * Slug the name on create. Another choice would
         * be to use spatie-sluggable package
         * This allows for manual overwrite
         */
        self::creating(function ($model) {
            /**
             * If model slug hasn't been set:
             * - automate it
             */
            /** @var User $model */
            if (! $model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function tours()
    {
        return $this->hasMany(Tour::class, 'travelId');
    }
}
