<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'travelId',
        'name',
        'startingDate',
        'price',
    ];

    protected $casts = [
        'startingDate' => 'date',
        'endingDate' => 'date',
    ];

    public static function boot(): void
    {
        parent::boot();
        self::saving(function ($model) {
            /** @var Tour $model */

            // If the startingDate has been changed, recalculate endingDate
            if ($model->isDirty(['startingDate'])) {
                /** @var Carbon $date */
                $date = $model->startingDate;
                /** @var Travel $travel */
                $travel = Travel::query()->find($model->travelId);
                $endingDate = $date->addDays($travel->numberOfDays);
                $model->unguard();
                $model->endingDate = $endingDate;
                $model->reguard();
            }
        });
    }

    protected function convertPriceToInt($value = null)
    {
        if (! $value) {
            $value = $this->price;
        }

        return ! is_int($value) ? $value * 100 : $value;
    }

    public function scopePriceFrom(Builder $query, $value): void
    {
        $value = $this->convertPriceToInt($value);
        $query->where('price', '>=', $value);
    }

    public function scopePriceTo(Builder $query, $value): void
    {
        $value = $this->convertPriceToInt($value);
        $query->where('price', '<=', $value);
    }

    public function scopeDateFrom(Builder $query, $value): void
    {
        $query->where('startingDate', '>=', $value);
    }

    public function scopeDateTo(Builder $query, $value): void
    {
        $query->where('startingDate', '<=', $value);
    }

    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travelId');
    }
}
