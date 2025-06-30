<?php

namespace Modules\Contract\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    protected $fillable = [
        'first_member',
        'second_member',
        'service_type',
        'description',
        'sessions_per_week',
        'start_date',
        'end_date',
        'is_online',
        'contract_start_date',
        'contract_end_date',
        'price',
        'expert_name',
        'expert_email',
        'trainee_name',
        'trainee_email',
    ];

    public function scopeWhereMine(Builder $builder, $otherUserId = null)
    {
        return $builder->where(function ($query) use ($otherUserId) {
            if ($otherUserId) {
                return $query->where(function ($query) use ($otherUserId) {
                    $query->where('first_member', auth()->id())->where('second_member', $otherUserId);
                })->orWhere(function ($query) use ($otherUserId) {
                    $query->where('first_member', $otherUserId)->where('second_member', auth()->id());
                });
            }

            $query->where('first_member', auth()->id())->orWhere('second_member', auth()->id());
        });
    }
}
