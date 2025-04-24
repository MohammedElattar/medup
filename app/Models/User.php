<?php

namespace App\Models;

use App\Models\Builders\UserBuilder;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Auth\Traits\HasVerifyTokens;
use Modules\Auth\Traits\UserRelations;
use Modules\Expert\Helpers\ExpertHelper;
use Modules\Subscription\Models\Subscription;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens,
        HasFactory,
        HasVerifyTokens,
        InteractsWithMedia,
        Notifiable,
        PaginationTrait,
        Searchable,
        SoftDeletes,
        UserRelations;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->forceFill([
                'name' => $model->first_name . ' ' . $model->middle_name,
            ]);
        });

        static::updating(function ($model) {
            if ($model->first_name && $model->middle_name) {
                $model->forceFill([
                    'name' => $model->first_name . ' ' . $model->middle_name,
                ]);
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'email',
        'phone',
        'type',
        'status',
        'locale',
        'password',
        AuthEnum::VERIFIED_AT,
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'chat_active' => 'boolean',
            'last_time_seen' => 'datetime',
            'status' => 'boolean',
            'fcm_tokens' => 'array',
        ];
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    public function resetAvatar(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function routeNotificationForFcm()
    {
        return $this->fcm_tokens;
    }

    public function addIsPremium()
    {
        $expertId = in_array(UserTypeEnum::getUserType($this), [UserTypeEnum::EXPERT, UserTypeEnum::EXPERT_LEARNER])
            ? ExpertHelper::getUserExpert($this)->id
            : null;

        $this->is_premium = Subscription::query()
            ->where('expert_id', $expertId)
            ->where('paid', true)
            ->where('ends_at', '>=', now())
            ->select('paid')
            ->limit(1)
            ->value('paid');
    }
}
